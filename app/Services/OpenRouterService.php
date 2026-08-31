<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OpenRouterService
{
    /**
     * The chat-completion endpoint.
     */
    private const ENDPOINT = '/chat/completions';

    /**
     * Whether the OpenRouter client is configured (an API key is present).
     */
    public static function configured(): bool
    {
        return ! empty(config('services.openrouter.api_key'));
    }

    /**
     * Default model resolved from config.
     */
    public function model(): string
    {
        return config('services.openrouter.model', 'nvidia/nemotron-3.5-lightning:free');
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
            'reasoning' => ['enabled' => (bool) config('services.openrouter.reasoning', $reasoning)],
            'temperature' => 0.5,
            'max_tokens' => 1024,
        ];

        try {
            $response = Http::withToken(config('services.openrouter.api_key'))
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
