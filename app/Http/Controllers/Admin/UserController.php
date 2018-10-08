<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\role;
use App\Models\role_user;
use Illuminate\Http\Request;
use App\Http\Requests\LablePost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = role::all();
        $file = User::orderBy('created_at', 'desc')->paginate(3);
        return view('amenu.user',['files'=>$file,'user'=>Auth::user()->toArray(),'roles'=>$role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $res = User::onlyTrashed()
            ->where('id', $request->id)
            ->restore();
        if($res)
            return redirect('user');
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
        $res = User::create($request->all());
        if(!$res){
            return redirect()->back()
                ->withErrors(array('加入文件失败'))->withInput();
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
        $label = User::findOrFail($id);
        $res = $label->update($request->all());
        if($res){
            return redirect()->back();
        }else{
            return redirect()->back()
                ->withErrors(array('更改文件失败'))->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        role_user::where('user_id',$id)->delete();
        if(isset($request->role))
            foreach ($request->role as $key => $value) {
                role_user::create(['user_id'=>$id,'role_id'=>$value]);
            }
        return redirect()->back();
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
            $file =User::orderBy('created_at', 'desc')->where('name','like','%'.$request->title.'%')->paginate(3);
        else
            $file = User::onlyTrashed()->where('name','like','%'.$request->title.'%')->paginate(3);
        return view('amenu.user',['files'=>$file,'user'=>Auth::user()->toArray()],compact("edit"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = User::destroy($id);
        if(!$res) {
            User::where('id', $id)->forceDelete();
            echo 'success';
        }else
            echo 'success';
    }
}
