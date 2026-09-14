<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'contact_preference',
        'source',
        'ip_address',
        'user_agent',
        'zapier_status',
        'zapier_sent_at',
        'zapier_response_code',
        'zapier_response_body',
        'zapier_error',
    ];

    protected function casts(): array
    {
        return [
            'zapier_sent_at' => 'datetime',
        ];
    }
}
