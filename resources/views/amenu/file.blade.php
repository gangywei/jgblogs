@extends('comment.admin.a_model')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            文件
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
                        <form role="form" action="{{url('file')}}/{{$edit or 'search'}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            @if(!isset($edit))
                                <a href="{{url('file\u\edit')}}"><button type="button" class="btn pull-right btn-info">回收站</button></a>
                            @else
                                <a href="{{url('file')}}"><button type="button" class="btn pull-right btn-info">分类管理</button></a>
                            @endif
                            <div class="input-group col-xs-9 input-group jgselect">
                                <button type="button" data-toggle="modal" data-target="#file" class="btn pull-left btn-info">新增分类</button>
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
                        <a href="{{url('file')}}" id="hidsrc" style="display: none"></a>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>文件名</th>
                                <th>文件介绍</th>
                                <th>更新时间</th>
                                <th>编辑文件</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td class="data-title">{{$file->title}}</td>
                                    <td class="data-content">{{$file->content}}</td>
                                    <td>{{$file->updated_at}}</td>
                                    <td  data-id="{{$file->id}}">
                                        <a class="btn btn-primary btn-sm {{ isset($edit) ? '' : 'rev_file' }}" {{ isset($edit) ? "href =". url('file/create')."?id=$file->id": "data-toggle=modal data-target=#file"}} >{{ isset($edit) ? '还原' : '修改' }}</a>
                                        <a class="btn btn-danger btn-sm {{ isset($edit) ? '' : 'del_file' }}" {{ isset($edit) ? "href =". url('file/comDelete')."/$file->id": ""}}>删除</a>
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
                    <h4 class="modal-title">新增文件</h4>
                </div>
                <div class="modal-body">
                    <div class="box-primary">
                        <form role="form" id="model_from" action="{{url('file')}}" method="post">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">文件内容</label>
                                    <input type="test" name="title" class="form-control" id="mod_title" placeholder="标签内容">
                                </div>
                                <div class="form-group">
                                    <label>文件介绍</label>
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
    <script src="{{ asset('js/admin/file.js') }}"></script>
@endsection