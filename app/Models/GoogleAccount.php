<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    /**
     * Whether the stored access token is still valid.
     */
    public function tokenIsValid(): bool
    {
        if (empty($this->access_token)) {
            return false;
        }

        if ($this->token_expires_at === null) {
            return true;
        }

        return $this->token_expires_at->isFuture();
    }
}
