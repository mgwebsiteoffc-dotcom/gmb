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
    ];
}
