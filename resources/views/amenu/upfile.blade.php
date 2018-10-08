@extends('comment.admin.a_model')

@section('css')
    <link rel="stylesheet" href={{ asset('vendor/upload/css/reset.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/upload/css/custom.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/upload/css/dragdropbox.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/upload/css/jquery.filer.css') }}>
    <link rel="stylesheet" href={{ asset('admin/plugins/datepicker/datepicker3.css') }}>
@endsection

@section('js')
    <script src={{ asset('vendor/upload/js/jquery.filer.min.js') }}></script>
    <script src={{ asset('vendor/upload/js/prettify.js') }}></script>
    <script src={{ asset('vendor/upload/js/scripts.js') }}></script>
    <script src={{ asset('vendor/upload/js/cesesss.js') }}></script>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            上传文件
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
                            {{ csrf_field() }}
                            <div class="input-group col-xs-3 input-group">
                                <button type="button" data-toggle="modal" data-target="#file" class="btn pull-left btn-info">新增文件目录</button>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">搜索
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a><button type="submit" style="    border: none;margin: 0;background: white;">文件名</button></a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                                <input type="text" name="title" class="form-control">
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="jFiler-items-list jFiler-items-grid">
                        {{-- {{dd($filedir)}} --}}
                        @foreach($filedir as $element)
                                {{-- {{dd($element)}} --}}
                                {{--  @if ($element["base"]=='img') --}}
                                    <li class="jFiler-item" style="width: 20%;" data-jfiler-index="0">
                                        <div class="jFiler-item-container">
                                            <div class="jFiler-item-inner">
                                                <div class="jFiler-item-thumb">
                                                    <div class="jFiler-item-status"></div>
                                                    <div class="jFiler-item-info">
                                                        <span class="jFiler-item-title"><b title={{$element["name"]}}>{{$element["name"]}}</b></span>
                                                        <span class="jFiler-item-others">{{$element["size"]}}</span>
                                                    </div>
                                                    <div class="jFiler-item-thumb-image">
                                                        @if (isset($element["path"]))
                                                            @if ($element['base']=='img')
                                                                <img src={{ asset($element["path"]) }}>
                                                            @elseif ($element['base']=='mp3')
                                                                <audio controls>
                                                                    <source src={{ asset($element["path"]) }}>
                                                                </audio>
                                                            @elseif ($element['base']=='video')
                                                                <video src="{{ asset($element["path"]) }}" controls="controls"></video>
                                                            @endif

                                                        @else
                                                            <span class="jFiler-icon-file f-file" style="-webkit-box-shadow: #29ca32 42px -55px 0px 0px inset; -moz-box-shadow: #29ca32 42px -55px 0px 0px inset; box-shadow: #29ca32 42px -55px 0px 0px inset;">{{$element["base"]}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="jFiler-item-assets jFiler-row">
                                                    <ul class="list-inline pull-left">
                                                        <li>
                                                            <div class="jFiler-jProgressBar" style="display: none;">
                                                                <div class="bar" style="width: 100%;"></div>
                                                            </div>
                                                            <div class="jFiler-item-others text-success">
                                                                <i class="icon-jfi-check-circle"></i>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <ul class="list-inline pull-right">
                                                        <li><a class="icon-jfi-trash jFiler-item-trash-action" href="{{ asset('delfile').'?path='.$element["path"] }}"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                {{-- @else
                                    <a href="{{url('upfile')}}/{{$element}}" class="btn btn-primary btn-sm">{{$element}}</a>
                                @endif --}}
                        @endforeach
                        </ul>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="jFiler-input-dragDrop">
                            @foreach ($alldir as $element)
                                @if ($element==$path)
                                    <a href="{{url('upfile')}}/{{$element}}" id="warn" class="btn btn-warning btn-sm">{{$element}}</a>
                                @else
                                    <a href="{{url('upfile')}}/{{$element}}" class="btn btn-primary btn-sm">{{$element}}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

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