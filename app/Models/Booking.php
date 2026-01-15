<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'business_id',
        'product_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'booking_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_at' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
