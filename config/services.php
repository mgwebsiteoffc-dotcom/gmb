<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'openrouter' => [
        'api_key' => env('OPENROUTER_API_KEY'),
        'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
        'model' => env('OPENROUTER_MODEL', 'nvidia/nemotron-3.5-lightning:free'),
        'reasoning' => env('OPENROUTER_REASONING', true),
        'timeout' => (int) env('OPENROUTER_TIMEOUT', 60),
    ],

    // Google OAuth 2.0 + Google Business Profile (My Business) API.
    // Used to connect real Google Business Profile accounts and import
    // verified locations, reviews, and metrics.
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', '/app/connect/google/callback'),
        'scopes' => array_filter(array_map('trim', explode(',', env(
            'GOOGLE_SCOPES',
            'openid,email,profile,https://www.googleapis.com/auth/business.manage'
        )))),
        // My Business Account Management API (accounts) + Business Profile API v4 (locations).
        'account_management_url' => env('GOOGLE_ACCOUNT_MANAGEMENT_URL', 'https://mybusinessaccountmanagement.googleapis.com/v1/accounts'),
        'oauth_token_url' => env('GOOGLE_OAUTH_TOKEN_URL', 'https://oauth2.googleapis.com/token'),
    ],

];
