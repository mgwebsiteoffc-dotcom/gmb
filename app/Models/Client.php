<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'onboarded_at' => 'date',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Resolve the brand logo: a real uploaded image URL if present, otherwise
     * the emoji fallback.
     */
    public function logoDisplay(): string
    {
        return $this->logo_url ?: ($this->logo ?: '🏢');
    }

    /**
     * Whether to render an <img> (uploaded logo) vs. plain text (emoji).
     */
    public function hasLogoImage(): bool
    {
        return ! empty($this->logo_url);
    }
}
