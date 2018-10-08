<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\h_history;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoriesController extends Controller
{
    //默认显示
    public function index()
    {
        $history =h_history::orderBy('created_at', 'desc')->paginate(3);
        return view('amenu.histories',['histories'=>$history,'user'=>Auth::user()->toArray()]);
    }

    //模态框新建
    public function store(Request $request)
    {
        $res = h_history::create($request->all());
        if(!$res){
            return redirect()->back()
                ->withErrors(array('加入历史失败'))->withInput();
        }else{
            return redirect()->back();
        }
    }

    //更新文件
    public function show(Request $request,$id)
    {
        $label = h_history::findOrFail($id);
        $res = $label->update($request->all());
        if($res){
            return redirect()->back();
        }else{
            return redirect()->back()
                ->withErrors(array('更改文件失败'))->withInput();
        }
    }
}
