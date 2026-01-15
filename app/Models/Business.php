<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name', 'type', 'email', 'phone', 'address',
        'currency', 'timezone',
        'logo',
        'status', 'subscription_status', 'subscription_ends_at'
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
    ];

}
