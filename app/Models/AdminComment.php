<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminComment extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
