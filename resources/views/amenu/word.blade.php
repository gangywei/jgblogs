@extends('comment.admin.a_model')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            留言
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
                        <form role="form" action="{{url('word')}}/{{$edit or 'search'}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            @if(!isset($edit))
                                <a href="{{url('word\u\edit')}}"><button type="button" class="btn pull-right btn-info">回收站</button></a>
                            @else
                                <a href="{{url('word')}}"><button type="button" class="btn pull-right btn-info">留言管理</button></a>
                            @endif
                            <div class="input-group col-xs-9 input-group jgselect">
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control" placeholder="留言者">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-info btn-flat">搜索</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href="{{url('word')}}" id="hidsrc" style="display: none"></a>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>留言者</th>
                                <th>文件介绍</th>
                                <th>更新时间</th>
                                <th>编辑文件</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($words as $word)
                                <tr>
                                    <td class="data-title">{{$word->name}}</td>
                                    <td class="data-content">{{$word->contents}}</td>
                                    <td>{{$word->updated_at}}</td>
                                    <td  data-id="{{$word->id}}">
                                        <a class="btn btn-primary btn-sm rev_word" {{ isset($edit) ? "href =". url('file/create')."?id=$word->id": "data-toggle=modal data-target=#file"}} >{{ isset($edit) ? '还原' : '修改' }}</a>
                                        <a class="btn btn-danger btn-sm del_word" >删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr></tr>
                            </tfoot>
                        </table>
                        <div>
                            {{ $words->links() }}
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/admin/word.js') }}"></script>
@endsection