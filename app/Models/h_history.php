<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class h_history extends Model
{
    protected $fillable = [
        'contents',
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d',strtotime($value));
    }
}
