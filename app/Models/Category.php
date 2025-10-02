<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia,SoftDeletes;

    public array $translatable = ['name'];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->orderBy('order');
    }

    public function products()
    {
        //        return $this->hasMany(Product::class)->orderBy('order');
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id')->orderBy('order');

    }

    //    public function productsMany()
    //    {
    //        return $this->belongsToMany(Product::class);
    //    }

    public function categoryOrder()
    {
        return $this->belongsTo(CategoryOrder::class)->orderBy('order');
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

        static::creating(function ($category) {
            if (! $category->slug) {
                $category->slug = self::cleanUnicodeAndSlug($category->name);
            }

            $category->order = Category::max('order') + 1;
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = self::cleanUnicodeAndSlug($category->name);
            }

            // If order changes, reorder siblings
            if ($category->isDirty('order')) {
                $oldOrder = $category->getOriginal('order');
                $newOrder = $category->order;

                if ($oldOrder < $newOrder) {
                    // Moving down: shift others up
                    Category::where('order', '>', $oldOrder)
                        ->where('order', '<=', $newOrder)
                        ->decrement('order');
                } elseif ($oldOrder > $newOrder) {
                    // Moving up: shift others down
                    Category::where('order', '<', $oldOrder)
                        ->where('order', '>=', $newOrder)
                        ->increment('order');
                }
            }

        });

        // Ensure related subcategories and products are deleted via Eloquent so their media is cleaned as well
        static::deleting(function ($category) {
            // Delete subcategories explicitly to trigger media cleanup
            $category->subcategories()->get()->each(function ($sub) {
                $sub->delete();
            });
            // Delete products explicitly (in case they have media or related records in the future)
            $category->products()->get()->each(function ($product) {
                $product->delete();
            });
            $category->clearMediaCollection();

            foreach ($category->products as $product) {
                $product->delete(); // triggers Product deleting event
            }

            Category::where('order', '>', $category->order)
                ->decrement('order');
        });
    }
}
