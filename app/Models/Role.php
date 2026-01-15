<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'business_id', 'name'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
