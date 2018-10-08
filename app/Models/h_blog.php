<?php

namespace App\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class h_blog extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'contents','author','lists','readnums','inter'
    ];
    //关联文件
    public function file()
    {
        return $this->belongsTo('App\Models\h_file','lists');
    }

    public function getContentsAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }


    public function setContentsAttribute($value)
    {
        $this->attributes['contents'] = htmlspecialchars(trim($value));
    }
    //多对多关联
    public function labels()
    {
        return $this->belongsToMany('App\Models\h_label','blog_labels','blogs','labels');
    }

    //博客首页得到排行榜
    public static function getAll($size){
        $res = h_blog::orderBy('created_at', 'DESC')->paginate($size);
        return $res;
    }
    //得到博客搜索结果
    public static function searchBlog($search){
        $res = h_blog::where('title','like','%'.$search.'%')->orderBy('created_at', 'desc') ->paginate(4);
        return $res;
    }
    //博客的详情页面（注意已经删除的字段）
    public static function readBlog($id){
        $res = h_blog::whereNull('deleted_at')->find($id);
        return $res;
    }
    //修改阅读量
    public static function changRead($id){
        $res = h_blog::where('id',$id)->increment('readnums');
        return $res;
    }
}
