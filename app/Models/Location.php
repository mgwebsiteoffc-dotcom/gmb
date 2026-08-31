<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'verified' => 'boolean',
        'rating' => 'float',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function mediaItems()
    {
        return $this->hasMany(MediaItem::class);
    }
}
