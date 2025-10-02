<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Subcategory extends Model implements HasMedia
{
    use HasTranslations,InteractsWithMedia,SoftDeletes;

    public array $translatable = ['name'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('order');
    }

    public function categoryOrder()
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

        static::creating(function ($subcategory) {
            if (! $subcategory->slug) {
                $subcategory->slug = self::cleanUnicodeAndSlug($subcategory->name).'-sub';
            }

            $subcategory->order = Subcategory::max('order') + 1;

        });

        static::updating(function ($subcategory) {

            if ($subcategory->isDirty('name')) {
                $subcategory->slug = self::cleanUnicodeAndSlug($subcategory->name).'-sub';
            }

            // If order changes, reorder siblings
            if ($subcategory->isDirty('order')) {
                $oldOrder = $subcategory->getOriginal('order');
                $newOrder = $subcategory->order;

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

        });

        static::deleting(function ($subcategory) {
            $order = $subcategory->order; // save the current order first

            // Delete related media/products
            $subcategory->clearMediaCollection();
            foreach ($subcategory->products as $product) {
                $product->delete(); // triggers Product deleting event
            }

            // Reorder remaining subcategories
            Subcategory::where('order', '>', $order)
                ->decrement('order');
        });

    }
}
