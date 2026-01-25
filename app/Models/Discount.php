<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $casts = [
        'valid_till' => 'date',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
