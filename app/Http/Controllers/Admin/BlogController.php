<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\blog_label;
use App\Models\h_blog;
use App\Models\h_file;
use App\Models\h_label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * 显示博客
     */
    public function index()
    {
        $blog = h_blog::getAll(10);
        return view('amenu.blog',['blogs'=>$blog,'user'=>Auth::user()->toArray()]);
    }

    /**
     * 还原删除的博客
     */
    public function create(Request $request)
    {
        $res = h_blog::onlyTrashed()
            ->where('id', $request->id)
            ->restore();
        if($res)
            return redirect()->back();
        else
            return redirect()->back()->withErrors("博客还原失败");
    }

    public function vailBlog($data){
        $this->validate($data, [
            'title' => 'required|max:50',
            'author' => 'required|max:30',
            'contents' => 'required',
            'inter'=>'required|max:200',
        ],[
            'required'=>':attribute 为必填项',
            'max'=>':attribute 长度超出范围'
        ],[
            'title' => '文章',
            'author' => '作者',
            'contents' => '文章主体',
            'inter' => '文章简介'
        ]);
    }
    /**
     * 新建博客
     */
    public function store(Request $request)
    {
        $this->vailBlog($request);
        $blog = h_blog::create($request->all());
        $labels = $request->labels;
        if(is_array($labels)){
            foreach($labels as $label)
                $data[] = ['blogs'=>$blog->id,'labels'=>$label];
            blog_label::insert($data);
        }
        return redirect('blog');
    }

    /**
     * 更新博客
     */
    public function update(Request $request, $id)
    {
        $this->vailBlog($request);
        $blog = h_blog::find($id);
        blog_label::where('blogs',$id)->delete();
        if(is_array($request->labels)){
            $labels = $request->labels;
            foreach($labels as $lab)
                $data[] = ['blogs'=>$id,'labels'=>$lab];
            $res = blog_label::insert($data);
            if(!$res)
                return redirect()->back()->withErrors("更新标签失败");
        }
        if ($request->lists!="无选择")
            $blog->lists = $request->lists;
        $blog->inter = $request->inter;
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->contents = $request->contents;
        $res = $blog->save();
        if($res)
            return redirect('blog');
        else
            return redirect()->back()->withErrors("更新文章失败");
    }

    /**
     * 删除博客
     */
    public function show($id)
    {
        $res = h_blog::destroy($id);
        if(!$res)
            return redirect()->back()->withErrors("博客删除失败");
        return redirect()->back();
    }
    /**
     * 完全删除博客（事务处理）
     */
    public function comDelete($id)
    {
        $res = blog_label::where('blogs',$id)->delete();
        dd($res);
        $res = h_blog::where('id',$id)->forceDelete();
        if(!$res)
            return redirect()->back()->withErrors("博客删除失败");
        return redirect()->back();
    }

    /**
     * 得到删除的博客（回收站）
     */
    public function edit($id)
    {
        $blog = h_blog::onlyTrashed()->paginate(10);
        return view('amenu.blog',['blogs'=>$blog,'user'=>Auth::user()->toArray(),'edit'=>'edit']);
    }

    /**
     * 搜索博客
     */
    public function destroy(Request $request,$id)
    {
        $edit = $id;
        if($id=='edit')
            $blog =h_blog::orderBy('created_at', 'desc')->where('title',$request->title)->orWhere('author',$request->title)->paginate(10);
        else
            $blog =h_blog::onlyTrashed()->where('title','like','%'.$request->title.'%')->orWhere('author','like','%'.$request->title.'%')->paginate(10);
        return view('amenu.blog',['blogs'=>$blog,'user'=>Auth::user()->toArray()],compact("edit"));
    }
    /**
     * 修改博客
     */
    public function ceblog(Request $request,$blog=""){
        $blogs = "";
        if(!empty($blog)){
            $blogs = h_blog::find($blog);
        }
        //dd($blogs->labels);
        $file = h_file::all();
        $label = h_label::all();
        return view('admin.ceblog',['user'=>Auth::user()->toArray(),'files'=>$file,'labels'=>$label,'blogs'=>$blogs]);
    }
}
