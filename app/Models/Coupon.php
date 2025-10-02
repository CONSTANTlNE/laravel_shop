<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function promoter(){
        return $this->belongsTo(Promoter::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
