<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class h_label extends Model
{
    //最美的平凡
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'content',
    ];

    //多对多关联
    public function blogs()
    {
        return $this->belongsToMany('App\Models\h_blog','blog_labels','labels','blogs');
    }
    //标签分页显示
    public static function getLabel($size=10){
        $res =h_label::orderBy('created_at', 'desc')->paginate($size);
        return $res;
    }
}
