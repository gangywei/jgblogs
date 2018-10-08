@extends('comment.admin.a_model')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins//select2/select2.min.css') }}">
    <style>
        #edui1_iframeholder{
            min-height: 200px;
        }
    </style>
@endsection

@section('content')
        <section class="content-header">
            <h1>
                创建
                <small>博客</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>主页</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="box">

                <div class="box-body">

                    @if ($blogs!="")
                        <form action="{{url('blog')}}/{{$blogs->id}}" method="post" role="form">
                        {{ method_field('PUT') }}
                    @else
                        <form action="{{url('blog')}}" method="post" role="form">
                    @endif
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>题目</label>
                                    <input type="text" name="title" value="{{ $blogs->title or '' }}" class="form-control" placeholder="文章题目">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>作者</label>
                                    <input type="text" name="author" value="{{ $blogs->author or '' }}" class="form-control" placeholder="文章作者">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>文件目录</label>
                                    <select class="form-control select2" name="lists" style="width: 100%;">
                                        <option selected="selected">无选择</option>
                                        @if (count($files) > 0)
                                            @if ($blogs!="")
                                                @foreach ($files->all() as $file)
                                                    @if($file['title']==$blogs->file['title'])
                                                        <option value="{{$file['id']}}" selected="selected">{{$file['title']}}</option>
                                                    @else
                                                        <option value="{{$file['id']}}" >{{$file['title']}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($files->all() as $file)
                                                    <option value="{{$file['id']}}" >{{$file['title']}}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>标签</label>
                                    <select class="form-control select2" name="labels[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                        @if (count($labels) > 0)
                                            @if ($blogs!="")
                                                @foreach ($labels->all() as $label)
                                                    {{$select = false}}
                                                    @foreach ($blogs->labels as $lab)
                                                        @if ($label->id==$lab->id)
                                                            {{$select = true}}
                                                        @endif
                                                    @endforeach
                                                    @if ($select)
                                                        <option value="{{$label['id']}}" selected="selected">{{$label['title']}}</option>
                                                    @else
                                                        <option value="{{$label['id']}}">{{$label['title']}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($labels->all() as $label)
                                                    <option value="{{$label['id']}}">{{$label['title']}}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>文章简介</label>
                                    <textarea class="form-control" name="inter" maxlength="200" rows="3" placeholder="输入文章简介，至多200字">{{ $blogs->inter or '' }}</textarea>
                                </div>
                            </div>
                        </div>
                       <script id="editor" name="contents" type="text/plain" >
                            @if ($blogs!="")
                                @php
                                    echo $blogs->contents
                                @endphp
                            @endif
                        </script>
                        <div class="row">
                            <button type="submit" class="btn btn-info col-md-2 btn-flat margin">@if ($blogs!="")修改博客@else创建博客@endif</button>
                        </div>
                    </form>
                    </div>
            </div>
        </section>


        <!-- /.content -->
@endsection

@section('js')
    <script src="{{ asset('admin/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('plug/ue/ueditor.config.js')}}"></script>
    <script src="{{ asset('plug/ue/ueditor.all.min.js')}}"></script>
    <script src="{{ asset('plug/ue/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('editor');
        $(".select2").select2();
    </script>
@endsection


