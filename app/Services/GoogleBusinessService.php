<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Real Google Business Profile (My Business) OAuth 2.0 + API integration.
 *
 * Flow (server-side, authorization-code grant):
 *   1. authorizationUrl()   -> build the Google consent screen URL.
 *   2. fetchTokens($code)   -> exchange the one-time code for access/refresh tokens.
 *   3. fetchAccounts()      -> list the Google Business Profile accounts the user owns.
 *   4. fetchLocations()     -> list every verified location under an account.
 *
 * All responses degrade gracefully: when Google credentials are not configured
 * every public helper returns false/empty so the rest of the app keeps working.
 */
class GoogleBusinessService
{
    /**
     * Whether Google OAuth is configured (a client id + secret are present).
     */
    public static function configured(): bool
    {
        return ! empty(config('services.google.client_id'))
            && ! empty(config('services.google.client_secret'));
    }

    /**
     * A stable OAuth "state" token to prevent CSRF on the callback.
     */
    public static function stateToken(): string
    {
        return Str::random(40);
    }

    /**
     * Build the Google authorization (consent) URL.
     *
     * @param  string  $state  CSRF token to round-trip through the callback.
     * @param  bool  $promptAccount  Force account selection when possible.
     */
    public function authorizationUrl(string $state, bool $promptAccount = false): string
    {
        $params = [
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => $this->redirectUri(),
            'response_type' => 'code',
            'scope' => implode(' ', config('services.google.scopes', [])),
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent',
        ];

        if ($promptAccount) {
            $params['prompt'] .= ' select_account';
        }

        return 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query($params);
    }

    /**
     * The absolute redirect URI that Google sends the user back to.
     */
    public function redirectUri(): string
    {
        $configured = config('services.google.redirect', '/app/connect/google/callback');

        // If the value is a relative path, prefix it with the app URL.
        if (str_starts_with($configured, '/')) {
            return rtrim(config('app.url'), '/').$configured;
        }

        return $configured;
    }

    /**
     * Exchange the one-time authorization code for OAuth tokens.
     *
     * @return array{access_token:string, refresh_token?:string|null, expires_in:int, token_type:string}
     */
    public function fetchTokens(string $code): array
    {
        $response = Http::asForm()
            ->timeout(30)
            ->post(config('services.google.oauth_token_url', 'https://oauth2.googleapis.com/token'), [
                'code' => $code,
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => $this->redirectUri(),
                'grant_type' => 'authorization_code',
            ]);

        if ($response->failed()) {
            Log::error('Google OAuth token exchange failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RuntimeException('Google authorization failed. The code may be expired or the client credentials are invalid.');
        }

        $data = $response->json();

        if (empty($data['access_token'])) {
            throw new RuntimeException('Google did not return an access token.');
        }

        return $data;
    }

    /**
     * Refresh an expired access token using the stored refresh token.
     */
    public function refreshAccessToken(string $refreshToken): array
    {
        $response = Http::asForm()
            ->timeout(30)
            ->post(config('services.google.oauth_token_url', 'https://oauth2.googleapis.com/token'), [
                'refresh_token' => $refreshToken,
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'grant_type' => 'refresh_token',
            ]);

        if ($response->failed()) {
            Log::warning('Google refresh token exchange failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RuntimeException('Google refresh token is invalid.');
        }

        // A refresh response may or may not include a new refresh_token.
        return array_merge(['refresh_token' => $refreshToken], $response->json());
    }

    /**
     * Fetch the list of Google Business Profile accounts for the connected user.
     *
     * @return array<int, array{name:string, accountName:string, displayName:string, type:string}>
     */
    public function fetchAccounts(string $accessToken): array
    {
        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->timeout(30)
            ->get(config('services.google.account_management_url', 'https://mybusinessaccountmanagement.googleapis.com/v1/accounts').'?pageSize=100');

        if ($response->failed()) {
            Log::warning('Google accounts fetch failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        $accounts = $response->json('accounts', []);

        return array_values(array_map(function ($account) {
            // Resource name like "accounts/1234567890"
            $name = $account['name'] ?? '';
            return [
                'name' => $name,
                'accountName' => preg_replace('#^accounts/#', '', $name),
                'displayName' => $account['accountName'] ?? ($account['name'] ?? 'Unknown account'),
                'type' => $account['type'] ?? 'LOCATION_GROUP',
            ];
        }, $accounts));
    }

    /**
     * Fetch every verified location under an account (paginated).
     *
     * @return array<int, array<string,mixed>>
     */
    public function fetchLocations(string $accessToken, string $accountName): array
    {
        $endpoint = 'https://mybusiness.googleapis.com/v4/'.$accountName.'/locations';

        $locations = [];
        $pageToken = null;

        do {
            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->timeout(30)
                ->get($endpoint, array_filter([
                    'pageSize' => 100,
                    'pageToken' => $pageToken,
                ]));

            if ($response->failed()) {
                Log::warning('Google locations fetch failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'account' => $accountName,
                ]);
                break;
            }

            $locations = array_merge($locations, $response->json('locations', []));
            $pageToken = $response->json('nextPageToken');
        } while ($pageToken);

        return $locations;
    }
}
