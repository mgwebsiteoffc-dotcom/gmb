<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
