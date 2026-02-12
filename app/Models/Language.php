<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Opcodes\LogViewer\Facades\Cache;

class Language extends Model
{
    protected static function boot()
    {

        parent::boot();

        // Use a single listener for both create and update
        static::saved(function ($product) {
            Cache::forget('locales');
        });

        static::deleted(function ($product) {
            Cache::forget('locales');
        });
    }
}
