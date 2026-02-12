<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'products_details' => 'array',
        'refund_details' => 'array',
        'callback_data' => 'array',
        'presents' => 'array',
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

    public function waybill()
    {
        return $this->hasOne(Waybill::class);
    }

    public function presentsRelation()
    {
        // We point back to the Product class, using the 'order_present' pivot table
        return $this->belongsToMany(
            Product::class,    // The related model is also a Product
            'order_present',   // Your pivot table name
            'order_id',        // The column for the product "owning" the presents
            'present_id'       // The column for the product "acting" as the present
        );
    }

    public function adminComments()
    {
        return $this->morphMany(AdminComment::class, 'commentable');
    }
}
