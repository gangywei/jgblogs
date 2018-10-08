@extends('comment.admin.a_model')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/select/src/ui-choose.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            用户
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
                        <form role="form" action="{{url('user')}}/{{$edit or 'search'}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="input-group col-xs-3 input-group">
                                <button type="button" data-toggle="modal" id="adduser" data-target="#file" class="btn pull-left btn-info">新增用户</button>
                                <div class="input-group-btn">

                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">搜索
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a><button type="submit" style="border: none;margin: 0;background: white;">用户名</button></a></li>
                                    </ul>

                                </div>
                                <!-- /btn-group -->
                                <input type="text" name="title" class="form-control">
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href="{{url('user')}}" id="hidsrc" style="display: none"></a>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>用户名</th>
                                <th>用户介绍</th>
                                <th>用户权限</th>
                                <th>更新时间</th>
                                <th>编辑用户</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td class="data-title">{{$file->name}}</td>
                                    <td class="data-content">{{$file->email}}</td>
                                    <td id="zizid">
                                        @if($file->roles->count()!=0)
                                            @foreach ($file->roles as $label)
                                                <span class="label label-info role_id" data-id={{$label['id']}}>{{$label['description']}}</span>
                                            @endforeach</td>
                                        @else
                                            <span class="label label-info">没有分配角色</span>
                                        @endif
                                    <td>{{$file->updated_at}}</td>
                                    <td  data-id="{{$file->id}}">
                                        <a class="btn btn-primary btn-sm {{ isset($edit) ? '' : 'rev_file' }}" {{ isset($edit) ? "href =". url('user/create')."?id=$file->id": "data-toggle=modal data-target=#file"}} >{{ isset($edit) ? '还原' : '修改' }}</a>
                                        <a class="btn btn-primary btn-sm up_limt" data-toggle=modal data-target=#role >权限</a>
                                        <a class="btn btn-danger btn-sm del_file" >删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr></tr>
                            </tfoot>
                        </table>
                        <div>
                            {{ $files->links() }}
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
    <div class="modal fade" tabindex="-1" role="dialog" id="file">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">新增用户</h4>
                </div>
                <div class="modal-body">
                    <div class="box-primary">
                        <form role="form" id="model_from" action="{{url('user')}}" method="post">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">用户内容</label>
                                    <input type="test" name="title" class="form-control" id="mod_title" placeholder="标签内容">
                                </div>
                                <div class="form-group">
                                    <label>用户介绍</label>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="role">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">修改权限</h4>
                </div>
                <div class="modal-body">
                    <div class="box-primary">
                        <form role="form" id="model_from" action="{{url('\user\u\edit')}}" method="get">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <select class="ui-choose" name="role[]" multiple="multiple">
                                    @foreach ($roles as $role)
                                        <option class="opid" value="{{$role->id}}">{{$role->description}}</option>
                                    @endforeach
                                </select>
                                <input type="test" name="id" id="user_id" style="display:none" class="form-control" value="">
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary" id="ch_role" style="display: none">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" onclick="$('#ch_role').click();" class="btn btn-primary">保存更改</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/file.js') }}"></script>
    <script src="{{ asset('vendor/select/src/ui-choose.js') }}"></script>
    <script>
        $('.ui-choose').ui_choose();
        var uc_04 = $('#uc_04').ui_choose();
    </script>
@endsection