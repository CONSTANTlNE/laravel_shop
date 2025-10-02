<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    public function coupons(){
        return $this->hasMany(Coupon::class);
    }
}
