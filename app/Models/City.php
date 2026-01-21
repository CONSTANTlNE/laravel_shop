<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function shippingPrices()
    {
        return $this->hasMany(ShippingPrice::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
