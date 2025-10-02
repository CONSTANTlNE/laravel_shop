<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryOrder extends Model
{
    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function subcategory()
    {
        return $this->hasMany(Subcategory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $maxOrder = static::max('order');
            $category->order = $maxOrder ? ($maxOrder + 1) : 1;
        });

        static::updating(function ($category) {

            // If order changes, reorder siblings
            if ($category->isDirty('order')) {
                $oldOrder = $category->getOriginal('order');
                $newOrder = $category->order;

                if ($oldOrder < $newOrder) {
                    // Moving down: shift others up
                    CategoryOrder::where('order', '>', $oldOrder)
                        ->where('order', '<=', $newOrder)
                        ->decrement('order');
                } elseif ($oldOrder > $newOrder) {
                    // Moving up: shift others down
                    CategoryOrder::where('order', '<', $oldOrder)
                        ->where('order', '>=', $newOrder)
                        ->increment('order');
                }
            }

        });

        static::deleting(function ($category) {

            CategoryOrder::where('order', '>', $category->order)
                ->decrement('order');
        });

    }
}
