<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Subcategory extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

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
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('order');
    }

    public function categoryOrder(): BelongsTo
    {
        return $this->belongsTo(CategoryOrder::class);
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
        //        while (Subcategory::where('slug', $slug)
        //            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
        //            ->exists()) {
        //            $slug = $originalSlug.'-'.$counter++;
        //        }

        return $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subcategory) {

            if (! $subcategory->slug) {
                $subcategory->slug = self::cleanUnicodeAndSlug($subcategory->name);
            }

            // ⛔ Skip insert if slug already exists
            if (
                Subcategory::where('slug', $subcategory->slug)->exists()
            ) {
                return false; // cancels INSERT
            }

            // auto order
            $subcategory->order = (Subcategory::max('order') ?? 0) + 1;
        });

        static::updating(function ($subcategory) {

            if ($subcategory->isDirty('name')) {

                // get string from translatable name
                $name = is_array($subcategory->name)
                    ? $subcategory->getTranslation('name', 'ka')
                    : $subcategory->name;

                $newSlug = self::cleanUnicodeAndSlug($name, $subcategory->id);

                // ⛔ If slug already exists → DO NOT update slug
                if (
                    Subcategory::where('slug', $newSlug)
                        ->where('id', '!=', $subcategory->id)
                        ->exists()
                ) {
                    // keep old slug, allow update to continue
                    $subcategory->slug = $subcategory->getOriginal('slug') ?? $subcategory->slug;
                } else {
                    $subcategory->slug = $newSlug;
                }
            }

            // If order changes, reorder siblings
            if ($subcategory->isDirty('order')) {
                $oldOrder = $subcategory->getOriginal('order');
                $newOrder = $subcategory->order;

                // Ensure we have valid numbers to compare
                if ($oldOrder !== null && is_numeric($oldOrder) && is_numeric($newOrder)) {
                    if ($oldOrder < $newOrder) {
                        // Moving down: shift others up
                        Subcategory::where('order', '>', $oldOrder)
                            ->where('order', '<=', $newOrder)
                            ->decrement('order');
                    } elseif ($oldOrder > $newOrder) {
                        // Moving up: shift others down
                        Subcategory::where('order', '<', $oldOrder)
                            ->where('order', '>=', $newOrder)
                            ->increment('order');
                    }
                }
            }

        });

        static::deleting(function ($subcategory) {
            $order = $subcategory->order;

            // 1. Explicitly load the products to avoid the Lazy Loading error
            $subcategory->load('products');

            // 2. Delete related media
            $subcategory->clearMediaCollection();

            // 3. Now you can safely loop through the loaded collection
            foreach ($subcategory->products as $product) {
                $product->delete();
            }

            // 4. Reorder remaining subcategories
            Subcategory::where('order', '>', $order)->decrement('order');
        });

    }
}
