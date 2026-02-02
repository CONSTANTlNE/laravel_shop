<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Export extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
