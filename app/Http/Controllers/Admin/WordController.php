<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\h_word;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    //默认显示
    public function index()
    {
        $word =h_word::orderBy('created_at', 'desc')->paginate(3);
        return view('amenu.word',['words'=>$word,'user'=>Auth::user()->toArray()]);
    }

    //回收站还原
    public function create(Request $request)
    {
        $res = h_word::onlyTrashed()
            ->where('id', $request->id)
            ->restore();
        if($res)
            return redirect('word');
        else
            return redirect()->back()->withErrors("还原失败");
    }


    //更新文件
    public function show(Request $request,$id)
    {
        $label = h_word::findOrFail($id);
        $res = $label->update($request->all());
        if($res){
            return redirect()->back();
        }else{
            return redirect()->back()
                ->withErrors(array('更改文件失败'))->withInput();
        }
    }

    //回收站显示
    public function edit($id)
    {
        $word =h_word::onlyTrashed()->paginate(3);
        return view('amenu.word',['words'=>$word,'user'=>Auth::user()->toArray(),'edit'=>'edit']);
    }

    //搜索功能
    public function update(LablePost $request, $id)
    {
        $edit = $id;
        if($id!='edit')
            $word =h_word::orderBy('created_at', 'desc')->where('name',$request->title)->paginate(10);
        else
            $word = h_word::onlyTrashed()->where('name',$request->title)->paginate(10);
        return view('amenu.word',['words'=>$word,'user'=>Auth::user()->toArray()],compact("edit"));
    }

    //回收站彻底删除
    public function destroy($id)
    {
        $res = h_word::destroy($id);
        if(!$res)
            $res = h_word::where('id', $id)->forceDelete();
        if($res)
            return response()->json([
                'res' => 'success',
            ]);
        else
            return response()->json([
                'res' => 'error',
            ]);
    }
}
