<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'products_details' => 'array',
        'callback_data' => 'array',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
