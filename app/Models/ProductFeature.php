<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductFeature extends Model
{
    use HasTranslations;

    public array $translatable = ['feature_name', 'feature_text'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
