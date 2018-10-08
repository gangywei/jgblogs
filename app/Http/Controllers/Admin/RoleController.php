<?php

namespace App\Http\Controllers\Admin;

use App\Models\role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $file =role::orderBy('created_at', 'desc')->paginate(3);
        return view('amenu.role',['files'=>$file,'user'=>Auth::user()->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $res = role::onlyTrashed()
            ->where('id', $request->id)
            ->restore();
        if($res)
            return redirect('role');
        else
            return redirect()->back()->withErrors("还原失败");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('update', $request->user());
        $res = role::create($request->all());
        if(!$res){
            return redirect()->back()
                ->withErrors(array('加入角色失败'))->withInput();
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $label = role::findOrFail($id);
        $res = $label->update($request->all());
        if($res){
            return redirect()->back();
        }else{
            return redirect()->back()
                ->withErrors(array('更改角色失败'))->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file =role::onlyTrashed()->paginate(3);
        return view('amenu.role',['files'=>$file,'user'=>Auth::user()->toArray(),'edit'=>'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LablePost $request, $id)
    {
        $edit = $id;
        if($id!='edit')
            $file =role::orderBy('created_at', 'desc')->where('title','like','%'.$request->title.'%')->paginate(3);
        else
            $file = role::onlyTrashed()->where('title','like','%'.$request->title.'%')->paginate(3);
        return view('amenu.role',['files'=>$file,'user'=>Auth::user()->toArray()],compact("edit"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = role::destroy($id);
        if(!$res) {
            role::where('id', $id)->forceDelete();
            echo 'success';
        }else
            echo 'success';
    }
}
