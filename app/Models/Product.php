<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

#[ObservedBy([ProductObserver::class])]
class Product extends Model implements HasMedia
{
    use HasTranslations,InteractsWithMedia;

    public array $translatable = ['name', 'description'];

    protected $casts = [
        'price_history' => 'array',
        'removed_from_store' => 'boolean',
    ];

    protected $attributes = [
        'price_history' => '[]', // default empty array
        'removed_from_store' => false,
    ];

    public function registerMediaConversions(?Media $media = null): void
    {

        $this->addMediaConversion('thumbnail')
            ->performOnCollections('product_image')
            ->width(500)
            ->height(400)
            ->sharpen(10);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //    public function categories()
    //    {
    //        return $this->belongsToMany(Category::class);
    //    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function presents()
    {
        // We point back to the Product class, using our pivot table
        return $this->belongsToMany(
            Product::class,      // The related model
            'product_present',   // The pivot table name
            'product_id',        // Foreign key on pivot for THIS model
            'present_id'         // Foreign key on pivot for RELATED model
        );
    }

    /**
     * Reverse: Products that have this item as a present.
     * (Optional, but useful if you want to see where a gift is being used)
     */
    public function presentToProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'product_present',
            'present_id',
            'product_id'
        );
    }

    // Scope to hide presents from the main shop list
    public function scopeVisible($query)
    {
        return $query->where('is_present', false);
    }

    private static function cleanUnicodeAndSlug($string, $ignoreId = null): string
    {
        // If null given, return empty slug base
        if ($string === null) {
            return '';
        }

        if (class_exists('Normalizer')) {
            $string = \Normalizer::normalize($string, \Normalizer::FORM_C);
        }

        // Remove control/invisible characters
        $string = preg_replace('/[\p{C}]/u', '', $string);

        // Convert to lowercase with proper Unicode support
        $string = mb_strtolower($string, 'UTF-8');

        // Generate base slug
        $slug = Str::slug($string, '-');
        $originalSlug = $slug;

        // Ensure uniqueness
        //        $counter = 1;
        //        while (Product::where('slug', $slug)
        //            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
        //            ->exists()) {
        //            $slug = $originalSlug.'-'.$counter++;
        //        }

        return $slug;
    }

    public function formMainSingle(): HasOne
    {
        return $this->hasOne(ProductOrder::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // 1. Generate the initial slug
            if (! $product->slug) {
                $product->slug = self::cleanUnicodeAndSlug($product->name);
            }

            // 2. If it exists, append a number until it is unique
            $originalSlug = $product->slug;
            $counter = 1;

            while (Product::where('slug', $product->slug)->exists()) {
                $product->slug = $originalSlug.'-'.$counter;
                $counter++;
            }

            // 3. Auto-order logic (stays the same)
            $product->order = (Product::max('order') ?? 0) + 1;

            // NO 'return false' here! The insert will now always proceed.
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = self::cleanUnicodeAndSlug($product->name);
            }

            // If order changes, reorder siblings
            if ($product->isDirty('order')) {
                $oldOrder = $product->getOriginal('order');
                $newOrder = $product->order;

                // Ensure we have valid numbers to compare
                if ($oldOrder !== null && is_numeric($oldOrder) && is_numeric($newOrder)) {
                    if ($oldOrder < $newOrder) {
                        // Moving down: shift others up
                        Product::where('order', '>', $oldOrder)
                            ->where('order', '<=', $newOrder)
                            ->decrement('order');
                    } elseif ($oldOrder > $newOrder) {
                        // Moving up: shift others down
                        Product::where('order', '<', $oldOrder)
                            ->where('order', '>=', $newOrder)
                            ->increment('order');
                    }
                }
            }

        });

        static::deleting(function ($product) {
            // Delete all media in all collections
            $product->clearMediaCollection();

            Product::where('order', '>', $product->order)
                ->decrement('order');
        });

    }
}
