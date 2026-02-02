<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    public function cartItems()
    {
        return $this->morphMany(CartItem::class, 'owner');
    }

    public function orderItems()
    {
        return $this->morphMany(Order::class, 'owner');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function exports()
    {
        return $this->hasMany(Export::class, 'admin_id');
    }
}
