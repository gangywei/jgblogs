@extends('comment.admin.a_model')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            标签
            <small>管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <form role="form" action="{{url('label')}}/{{$edit or 'search'}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            @if(!isset($edit))
                                <a href="{{url('label\u\edit')}}"><button type="button" class="btn pull-right btn-info">回收站</button></a>
                            @else
                                <a href="{{url('label')}}"><button type="button" class="btn pull-right btn-info">标签管理</button></a>
                            @endif
                            <div class="input-group col-xs-9 input-group jgselect">
                                <button type="button" data-toggle="modal" data-target="#label" class="btn pull-left btn-info">新增标签</button>
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-info btn-flat">搜索</button>
                                    </span>
                                </div>
                            </div>
                        </form>


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href="{{url('label')}}" id="hidsrc" style="display: none"></a>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>标签名</th>
                                <th>标签介绍</th>
                                <th>更新时间</th>
                                <th>编辑标签</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($labels as $label)
                                <tr>
                                    <td class="data-title">{{$label->title}}</td>
                                    <td class="data-content">{{$label->content}}</td>
                                    <td>{{$label->updated_at}}</td>
                                    <td  data-id="{{$label->id}}">
                                        <a class="btn btn-primary btn-sm rev_lab" {{ isset($edit) ? "href =". url('label/create')."?id=$label->id": " data-toggle=modal data-target=#label"}} >{{ isset($edit) ? '还原' : '修改' }}</a>
                                        <a class="btn btn-danger btn-sm {{ isset($edit) ? '' : 'del_lab' }}" {{ isset($edit) ? "href =". url('label/comDelete')."/$label->id": " "}}>删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr></tr>
                            </tfoot>
                        </table>
                        <div>
                            {{ $labels->links() }}
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    {{--模态框--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">新增标签</h4>
                </div>
                <div class="modal-body">
                    <div class="box-primary">
                        <form role="form" id="model_from" action="{{url('label')}}" method="post">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">标签内容</label>
                                    <input type="test" name="title" class="form-control" id="mod_title" placeholder="标签内容">
                                </div>
                                <div class="form-group">
                                    <label>标签介绍</label>
                                    <textarea class="form-control" name="content" rows="3" id="mod_content" placeholder="标签介绍"></textarea>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" id="ch_lab" style="display: none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" onclick="$('#ch_lab').click();" class="btn btn-primary">保存更改</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/label.js') }}"></script>
@endsection