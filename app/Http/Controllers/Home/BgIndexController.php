<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\WordPost;
use App\Models\h_blog;
use App\Models\h_file;
use App\Models\h_word;
use App\Models\h_label;
use App\Models\h_history;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use phpDocumentor\Reflection\Types\Null_;

class BgIndexController extends BaseController
{
    //博客主页
    public function index(Request $request){
        if(!$request->search)
            $blog = h_blog::getAll(4);
        else
            $blog = h_blog::searchBlog($request->search);
        return view('home.index',['base'=>$this->base,'blogs'=>$blog,'ipdata'=>$this->number]);
    }
    //博客详情页
    public function blog($id){
        $blog = h_blog::readBlog($id);
        session(['read'=>['id'=>$id,'time'=>time()]]);
        if(!$blog)
            abort(404);
        $before = h_blog::where('created_at','>',$blog->created_at)->orderBy('created_at', 'asc')->limit(1)->get();
        $after = h_blog::where('created_at','<',$blog->created_at)->orderBy('created_at', 'desc')->limit(1)->get();
        return view('home.blog',['base'=>$this->base,'blog'=>$blog,'before'=>$before,'after'=>$after,'ipdata'=>$this->number]);
    }
    //归档方法
    public function archive(Request $request){
        $title = NULL;
        $blog = NULL;
        if(isset($request->file)){
            $file = h_file::find($request->file);
            $title = '查看 《'.$file->title."》 下的文章";
            $bloges = h_blog::orderBy('created_at', 'DESC')->where('lists',$request->file)->get();
        }elseif (isset($request->label)){
            $label = h_label::find($request->label);
            $title = '查看 《'.$label->title."》 下的文章";
            $bloges = h_label::orderBy('created_at', 'DESC')->find($request->label)->blogs()->get();
        }else{
            $bloges = h_blog::orderBy('created_at', 'DESC')->get();
        }
        if($bloges->count()!=0)
            foreach ($bloges as $bg){
                $date = date('Y',strtotime($bg->created_at));
                $bg->date = $date;
                $blog[$date][] = $bg->toArray();
            }
        return view('home.archive',['base'=>$this->base,'blogs'=>$blog,'title'=>$title,'ipdata'=>$this->number]);
    }

    //博客历史
    public function history(){
        $history = h_history::orderBy('created_at', 'desc')->get();
        return view('home.history',['base'=>$this->base,'history'=>$history,'ipdata'=>$this->number]);
    }

    //回复
    public function introduce(){
        $word = h_word::where([['r_id','=',NULL]])->orderBy('created_at', 'desc')->paginate(3);
        foreach($word as $wd){
            $data = h_word::where('bl_id',$wd->id)->orderBy('created_at', 'asc')->get();
                foreach($data as $da){
                    $da_id = h_word::where('id',$da->r_id)->orderBy('created_at', 'asc')->get();
                    $da->r_id = $da_id;
                }
            $word->words[$wd->id] = $data;
        }
        return view('home.introduce',['base'=>$this->base,'words'=>$word,'ipdata'=>$this->number]);
    }

    public function word(WordPost $request){
        $res = h_word::create($request->all());
        $time = date('Y-m-d H:i:s',time());
        $src = asset('img/home/visitor.png');
        if($res)
            if (!empty($request->r_id)) {
                    $user = h_word::find($request->r_id);
                    Mail::to($user->email)->send(new OrderShipped('博客有人回复了您的信息'));
            }
            return "<li class='comment'>
                        <div class='comment_wrapper'>
                            <div class='author'>
                                <div class='avatar'><img src=$src>
                                </div>
                                <div class='author-name'>
                                    <a href=$request->site><b>$request->name</b></a>
                                    <a class='respond' style='display: block;'>回复</a>
                                </div>
                                <div class='author-date'>
                                    <small>$time</small>
                                </div>
                            </div>
                            <div class='comment_content'><div class='p_part'><p>$request->contents</p></div></div>
                        </div>
                    </li>";
    }
}
