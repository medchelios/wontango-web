<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'email',
        'feedback',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
