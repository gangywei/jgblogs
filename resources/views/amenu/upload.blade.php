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
            上传
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

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="jFiler jFiler-theme-dragdropbox">
                            <input type="file" name="file" id="demo-fileInput-6" multiple="multiple">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="jFiler-input-dragDrop">
                            @foreach ($alldir as $element)
                                @if ($element==$path)
                                    <a href="{{url('uploads')}}/{{$element}}" id="warn" class="btn btn-warning btn-sm">{{$element}}</a>
                                @else
                                    <a href="{{url('uploads')}}/{{$element}}" class="btn btn-primary btn-sm">{{$element}}</a>
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
@endsection