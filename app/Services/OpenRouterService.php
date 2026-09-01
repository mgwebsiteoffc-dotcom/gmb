<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AgencySetting;
use RuntimeException;

class OpenRouterService
{
    /**
     * The chat-completion endpoint.
     */
    private const ENDPOINT = '/chat/completions';

    /**
     * The persisted agency settings (managed at brand end & by Super Admin).
     */
    private static function settings(): ?AgencySetting
    {
        try {
            return AgencySetting::first();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Resolve the API key: config/.env fallback, then the persisted setting.
     */
    private static function key(): ?string
    {
        if (! empty(config('services.openrouter.api_key'))) {
            return config('services.openrouter.api_key');
        }
        $settings = self::settings();
        return ($settings && ! empty($settings->ai_api_key)) ? $settings->ai_api_key : null;
    }

    /**
     * Whether the OpenRouter client is configured (an API key is present).
     */
    public static function configured(): bool
    {
        return ! empty(self::key());
    }

    /**
     * Default model resolved from the persisted setting, then config.
     */
    public function model(): string
    {
        $settings = self::settings();
        if ($settings && ! empty($settings->ai_model)) {
            return $settings->ai_model;
        }
        return config('services.openrouter.model', 'nvidia/nemotron-3.5-lightning:free');
    }

    /**
     * Resolve temperature from the persisted setting, then config.
     */
    private static function temperature(): float
    {
        $settings = self::settings();
        if ($settings && $settings->ai_temperature !== null && $settings->ai_temperature != 0) {
            return (float) $settings->ai_temperature;
        }
        return (float) config('services.openrouter.temperature', 0.5);
    }

    /**
     * Resolve max tokens from the persisted setting, then config.
     */
    private static function maxTokens(): int
    {
        $settings = self::settings();
        if ($settings && $settings->ai_max_tokens) {
            return (int) $settings->ai_max_tokens;
        }
        return (int) config('services.openrouter.max_tokens', 1024);
    }

    /**
     * Resolve reasoning flag from the persisted setting, then config.
     */
    private static function reasoningDefault(): bool
    {
        $settings = self::settings();
        if ($settings && $settings->ai_reasoning !== null) {
            return (bool) $settings->ai_reasoning;
        }
        return (bool) config('services.openrouter.reasoning', true);
    }

    /**
     * Run a single chat completion against OpenRouter.
     *
     * Mirrors the reference Python flow:
     *   POST /api/v1/chat/completions
     *   body: { model, messages, reasoning: { enabled: true } }
     *
     * @param  array<int, array{role:string,content:string}>  $messages
     * @return array{content:string, reasoning?:string|null, model:string}
     */
    public function complete(array $messages, ?string $model = null, bool $reasoning = true): array
    {
        if (! self::configured()) {
            throw new RuntimeException('OpenRouter API key is not configured.');
        }

        $model = $model ?: $this->model();

        // Preserve any assistant reasoning_details so the model can continue
        // reasoning from where it left off (mirrors the reference Python flow).
        $payload = [
            'model' => $model,
            'messages' => array_map(function ($m) {
                $out = ['role' => $m['role'], 'content' => $m['content']];
                if (! empty($m['reasoning_details'])) {
                    $out['reasoning_details'] = $m['reasoning_details'];
                }
                return $out;
            }, $messages),
            'reasoning' => ['enabled' => (bool) self::reasoningDefault() && $reasoning],
            'temperature' => self::temperature(),
            'max_tokens' => self::maxTokens(),
        ];

        try {
            $response = Http::withToken(self::key())
                ->acceptJson()
                ->timeout(config('services.openrouter.timeout', 60))
                ->post(rtrim(config('services.openrouter.base_url', 'https://openrouter.ai/api/v1'), '/').self::ENDPOINT, $payload);

            if ($response->failed()) {
                Log::error('OpenRouter request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'model' => $model,
                ]);
                throw new RuntimeException('OpenRouter request failed: '.$response->status());
            }

            $data = $response->json();

            $message = $data['choices'][0]['message'] ?? null;
            if (! $message || ! isset($message['content'])) {
                throw new RuntimeException('OpenRouter returned an unexpected response.');
            }

            return [
                'content' => (string) $message['content'],
                'reasoning' => $message['reasoning_details'] ?? ($message['reasoning'] ?? null),
                'model' => $message['model'] ?? $model,
            ];
        } catch (RuntimeException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('OpenRouter exception', ['error' => $e->getMessage()]);
            throw new RuntimeException('OpenRouter request exception: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Convenience single-turn helper (system + user).
     */
    public function chat(string $system, string $user, ?string $model = null, bool $reasoning = true): array
    {
        return $this->complete([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $user],
        ], $model, $reasoning);
    }

    /**
     * Build the next assistant message that preserves the previous reasoning so
     * a follow-up call can continue reasoning (mirrors the reference snippet).
     *
     * @param  array{content:string, reasoning?:string|null}  $result
     * @return array{role:string, content:string, reasoning_details?:string}
     */
    public function keepReasoning(array $result): array
    {
        $message = [
            'role' => 'assistant',
            'content' => $result['content'],
        ];

        if (! empty($result['reasoning'])) {
            $message['reasoning_details'] = $result['reasoning'];
        }

        return $message;
    }
}
