<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailRecipient extends Model
{
    protected $fillable = [
        'email',
        'status',
        'fail_count',
        'next_retry_at',
        'last_error',
    ];

    protected $casts = [
        'next_retry_at' => 'datetime',
    ];
}