<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $maxOrder = static::max('order');
            $order->order = $maxOrder ? ($maxOrder + 1) : 1;
        });

        static::updating(function ($order) {

            // If order changes, reorder siblings
            if ($order->isDirty('order')) {
                $oldOrder = $order->getOriginal('order');
                $newOrder = $order->order;

                // Ensure we have valid numbers to compare
                if ($oldOrder !== null && is_numeric($oldOrder) && is_numeric($newOrder)) {
                    if ($oldOrder < $newOrder) {
                        // Moving down: shift others up
                        ProductOrder::where('order', '>', $oldOrder)
                            ->where('order', '<=', $newOrder)
                            ->decrement('order');
                    } elseif ($oldOrder > $newOrder) {
                        // Moving up: shift others down
                        ProductOrder::where('order', '<', $oldOrder)
                            ->where('order', '>=', $newOrder)
                            ->increment('order');
                    }
                }
            }
        });

        static::deleting(function ($order) {

            ProductOrder::where('order', '>', $order->order)
                ->decrement('order');
        });

    }
}
