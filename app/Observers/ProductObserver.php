<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    public function saved(Product $product)
    {
        //        Cache::tags(['featured_products'])->flush();
        //        Cache::tags(['categories'])->flush();
    }

    public function deleted(Product $product)
    {
        //        Cache::tags(['featured_products'])->flush();
        //        Cache::tags(['categories'])->flush();
    }

    public function updated(Product $product)
    {
        // When quantity becomes 0
        if ($product->isDirty('quantity') && $product->quantity == 0) {
            // Dispatch event or send email
            Mail::to('owner@example.com')->send(new ProductOutOfStock($product));
        }
    }
}
