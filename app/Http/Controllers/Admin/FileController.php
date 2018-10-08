<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\h_file;
use App\Models\h_blog;
use Illuminate\Http\Request;
use App\Http\Requests\LablePost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{

    /**
     * 显示分类
     */
    public function index()
    {
        $file =h_file::orderBy('created_at', 'desc')->paginate(10);
        return view('amenu.file',['files'=>$file,'user'=>Auth::user()->toArray()]);
    }

    /**
     * 还原分类
     */
    public function create(Request $request)
    {

        $res = h_file::onlyTrashed()
            ->where('id', $request->id)
            ->restore();
        if($res)
            return redirect()->back();
        else
            return redirect()->back()->withErrors("还原失败");
    }

    /**
     * 创建分类
     */
    public function store(LablePost $request)
    {
        $this->authorize('update', $request->user());
        $res = h_file::create($request->all());
        if(!$res){
            return redirect()->back()
                ->withErrors(array('加入文件失败'))->withInput();
        }else{
            return redirect()->back();
        }
    }

    /**
     * 更新分类
     */
    public function show(Request $request,$id)
    {
        $label = h_file::findOrFail($id);
        $res = $label->update($request->all());
        if($res){
            return redirect()->back();
        }else{
            return redirect()->back()
                ->withErrors(array('更改文件失败'))->withInput();
        }
    }

    /**
     * 回收站显示分类
     */
    public function edit($id)
    {
        $file =h_file::onlyTrashed()->paginate(10);
        return view('amenu.file',['files'=>$file,'user'=>Auth::user()->toArray(),'edit'=>'edit']);
    }

    /**
     * 分类搜索
     */
    public function update(Request $request, $id)
    {
        $edit = $id;
        if($id!='edit')
            $file =h_file::orderBy('created_at', 'desc')->where('title','like','%'.$request->title.'%')->paginate(3);
        else
            $file = h_file::onlyTrashed()->where('title','like','%'.$request->title.'%')->paginate(3);
        return view('amenu.file',['files'=>$file,'user'=>Auth::user()->toArray()],compact("edit"));
    }

    /**
     * 分类删除
     */
    public function destroy($id)
    {
        $num = h_blog::where('lists',$id)->count();
        if($num>0)
            return response()->json([
                'res' => '删除分类失败，分类里有文章',
            ]);
        else {
            $res = h_file::destroy($id);
            if ($res)
                return response()->json([
                    'res' => 'success',
                ]);
            return response()->json([
                'res' => '操作失败',
            ]);
        }
    }
    /**
     * 分类完全删除
     */
    public function comDelete($id)
    {
        $res = h_file::where('id', $id)->forceDelete();
        if(!$res)
            return redirect()->back()
                ->withErrors(array('完全删除分类失败'))->withInput();
    }
}
