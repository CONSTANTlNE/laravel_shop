<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia,SoftDeletes;

    protected $casts = [
        'category_order_id' => 'integer',
        'category_id' => 'integer',
        'active' => 'boolean',
        'order' => 'integer',
    ];

    public array $translatable = ['name'];

    public function registerMediaConversions(?Media $media = null): void
    {

        $this->addMediaConversion('thumbnail')
            ->performOnCollections('category_image')
            ->width(400)
            ->height(500)
            ->sharpen(10);
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->orderBy('order');
    }

    public function products(): BelongsToMany
    {
        //        return $this->hasMany(Product::class)->orderBy('order');
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id')->orderBy('order');

    }

    //    public function productsMany()
    //    {
    //        return $this->belongsToMany(Product::class);
    //    }

    public function categoryOrder(): BelongsTo
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
        //        $counter = 1;
        //        while (Category::where('slug', $slug)
        //            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
        //            ->exists()) {
        //            $slug = $originalSlug.'-'.$counter++;
        //        }

        return $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {

            if (! $category->slug) {
                $category->slug = self::cleanUnicodeAndSlug($category->name);
            }

            // ⛔ Skip insert if slug already exists
            if (
                Category::where('slug', $category->slug)->exists()
            ) {
                return false; // cancels INSERT
            }

            // auto order
            $category->order = (Category::max('order') ?? 0) + 1;
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {

                // get string from translatable name
                $name = is_array($category->name)
                    ? $category->getTranslation('name', 'ka')
                    : $category->name;

                $newSlug = self::cleanUnicodeAndSlug($name, $category->id);

                // ⛔ If slug already exists → DO NOT update slug
                if (
                    Category::where('slug', $newSlug)
                        ->where('id', '!=', $category->id)
                        ->exists()
                ) {
                    // keep old slug, allow update to continue
                    $category->slug = $category->getOriginal('slug');
                } else {
                    $category->slug = $newSlug;
                }
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
