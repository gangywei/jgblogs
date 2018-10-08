@extends('comment.admin.a_model')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            博客
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
                        <form role="form" action="{{url('blog')}}/{{$edit or 'search'}}" method="post">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            @if(!isset($edit))
                                <a href="{{url('\blog\u\edit')}}"><button type="button" class="btn pull-right btn-info">回收站</button></a>
                            @else
                                <a href="{{url('blog')}}"><button type="button" class="btn pull-right btn-info">博客管理</button></a>
                            @endif
                            <div class="input-group col-xs-9 input-group jgselect">
                                <a href="{{route('ceblog')}}"><button type="button" class="btn pull-left btn-info">新增博客</button></a>
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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>文章题目</th>
                                <th>创建时间</th>
                                <th>标签</th>
                                <th>分类</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>{{$blog->title}}</td>
                                    <td>{{$blog->created_at}}</td>
                                    <td>
                                        @foreach ($blog->labels as $label)
                                            <span class="label label-info">{{$label['title']}}</span>
                                        @endforeach</td>
                                    <td><span class="label label-info">{{$blog->file['title']}}</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"  href="{{ isset($edit) ? url('blog/create')."?id=$blog->id":url('ceblog')."/$blog->id" }}">{{ isset($edit) ? '还原' : '修改' }}</a>
                                        <a class="btn btn-danger btn-sm" href="{{ isset($edit) ? url('blog/comDelete')."/$blog->id":url('blog')."/$blog->id"}}">删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr></tr>
                            </tfoot>
                        </table>

                        <div>
                            {{ $blogs->links() }}
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
