<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog_label extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'blogs', 'labels',
    ];
}
