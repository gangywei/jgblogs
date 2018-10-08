<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\h_label;
use App\Models\blog_label;
use Illuminate\Http\Request;
use App\Http\Requests\LablePost;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    /**
     *得到分页详情
     */
    public function index()
    {
        $label =h_label::getLabel();
        return view('amenu.label',['labels'=>$label,'user'=>Auth::user()->toArray()]);
    }

    /**
     *还原删除
     */
    public function create(Request $request)
    {
        $res = h_label::onlyTrashed()
            ->where('id', $request->id)
            ->restore();
        if($res)
            return redirect()->back();
        else
            return redirect()->back()->withErrors("还原失败");
    }

    /**
     * 新建标签
     */
    public function store(LablePost $request)
    {
        $this->authorize('update', $request->user());
        $res = h_label::create($request->all());
        if(!$res){
            return redirect()->back()
                ->withErrors(array('加入标签失败'))->withInput();
        }else{
            return redirect()->back();
        }
    }

    /**
     * 修改标签
     */
    public function show(Request $request,$id)
    {
        $label = h_label::findOrFail($id);
        $res = $label->update($request->all());
        if($res){
            return redirect()->back();
        }else{
            return redirect()->back()
                ->withErrors(array('更改标签失败'))->withInput();
        }
    }

    /**
     *
     */
    public function edit($id)
    {
        $label =h_label::onlyTrashed()->paginate(10);
        return view('amenu.label',['labels'=>$label,'user'=>Auth::user()->toArray(),'edit'=>'edit']);
    }

    /**
     * 搜索标签
     */
    public function update(Request $request, $id)
    {
        $edit = $id;
        if($id = 'edit')
            $label =h_label::orderBy('created_at', 'desc')->where('title','like','%'.$request->title.'%')->paginate(3);
        else
            $label =h_label::onlyTrashed()->where('title','like','%'.$request->title.'%')->paginate(3);
        return view('amenu.label',['labels'=>$label,'user'=>Auth::user()->toArray()],compact("edit"));
    }

    /**
     * 删除标签
     */
    public function destroy($id)
    {
        $num = blog_label::where('labels',$id)->count();
        if($num>0)
            return response()->json([
                'res' => '删除标签失败，标签里有文章',
            ]);
        else {
            $res = h_label::destroy($id);
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
        $res = h_label::where('id', $id)->forceDelete();
        if(!$res)
            return redirect()->back()
                ->withErrors(array('完全删除分类失败'))->withInput();
    }
}
