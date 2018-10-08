<?php

namespace App\Http\Controllers\Home;

use App\Models\h_blog;
use App\Models\h_file;
use App\Models\h_label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
//得到侧边栏的数据
class BaseController extends Controller
{
    protected $base;
    protected $number;
    public  function __construct(){
        $labels = h_label::all()->toArray();
        $files = h_file::all()->toArray();
        $blogs = h_blog::latest()
            ->limit(8)->get()->toArray();
        $this->base = Array('labels'=>$labels,'files'=>$files,'blogs'=>$blogs);
    }
}
