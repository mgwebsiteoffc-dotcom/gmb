<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Ordered, active FAQs for a given category (or all).
     */
    public function scopeVisible(Builder $query, ?string $category = null): Builder
    {
        return $query->where('is_active', true)
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Group FAQs by their category for the FAQ hub page.
     */
    public static function groupedVisible(): \Illuminate\Support\Collection
    {
        return static::visible()->get()->groupBy('category');
    }

    public static function categories(): array
    {
        return static::query()->where('is_active', true)->distinct()->orderBy('category')->pluck('category')->all();
    }
}
