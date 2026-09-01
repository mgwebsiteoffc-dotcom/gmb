<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AgencySetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'email_alerts' => 'boolean',
        'sms_alerts' => 'boolean',
        'payment_enabled' => 'boolean',
        'ai_reasoning' => 'boolean',
        'plan_monthly_price' => 'float',
        'plan_per_location_price' => 'float',
        'ai_temperature' => 'float',
        'ai_max_tokens' => 'integer',
    ];

    /**
     * The client/brand this setting row belongs to (null = global defaults).
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Resolve (and lazily create) the settings row for a given brand/client.
     * Each brand gets its own row seeded from its own name/color/POC so it never
     * shows another brand's (or the platform's) data. `null` = global defaults
     * managed by the Super Admin.
     */
    public static function workspace(?int $clientId): self
    {
        $client = $clientId ? Client::find($clientId) : null;

        $defaults = [
            'agency_name' => $client?->name ?? 'Untab Local Growth Agency',
            'custom_domain' => $client ? Str::slug($client->name).'.untab.com' : 'clients.untab.com',
            'brand_color' => $client?->color ?? '#1a35c8',
            'support_email' => $client?->poc_email ?? 'support@untab.com',
            'ai_model' => config('services.openrouter.model', 'nvidia/nemotron-3.5-lightning:free'),
            'email_alerts' => true,
            'sms_alerts' => false,
            'payment_provider' => 'stripe',
            'payment_mode' => 'test',
            'payment_currency' => 'USD',
        ];

        return static::firstOrCreate(['client_id' => $clientId], $defaults);
    }

    /**
     * Human-friendly label for the active payment provider.
     */
    public function paymentProviderLabel(): string
    {
        return match ($this->payment_provider) {
            'stripe' => 'Stripe',
            'razorpay' => 'Razorpay',
            'paypal' => 'PayPal',
            'offline' => 'Offline / Manual',
            default => 'Stripe',
        };
    }

    /**
     * Convenience flag: whether the payment gateway is fully configured.
     */
    public function paymentConfigured(): bool
    {
        return $this->payment_enabled
            && $this->payment_provider !== 'offline'
            && ! empty($this->payment_public_key)
            && ! empty($this->payment_secret_key);
    }
}
