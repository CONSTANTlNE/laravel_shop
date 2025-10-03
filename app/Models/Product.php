<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasTranslations,InteractsWithMedia,SoftDeletes;

    public array $translatable = ['name', 'description'];

    protected $casts = [
        'price_history' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

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

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function discount(){
        return $this->belongsTo(Discount::class);
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
        $counter = 1;
        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug.'-'.$counter++;
        }

        return $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (! $product->slug) {
                $product->slug = self::cleanUnicodeAndSlug($product->name);
            }

            $product->order = Product::max('order') + 1;
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = self::cleanUnicodeAndSlug($product->name);
            }

            // If order changes, reorder siblings
            if ($product->isDirty('order')) {
                $oldOrder = $product->getOriginal('order');
                $newOrder = $product->order;

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

        });

        static::deleting(function ($product) {
            // Delete all media in all collections
            $product->clearMediaCollection();

            Product::where('order', '>', $product->order)
                ->decrement('order');
        });

    }
}
