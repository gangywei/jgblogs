@extends('comment.home.h_model')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home/word.css') }}">
@endsection

@section('nav')
    <div>
        <nav id="nav-menu" class="clearfix">
            <a href="{{url('index')}}"><i class="fa fa-home"> 首页</i></a>
            <a href="{{url('archive')}}"><i class="fa fa-archive"> 归档</i></a>
            <a href="{{url('introduce')}}" class="current"><i class="fa fa-user"> 关于</i></a>
            <a href="{{url('history')}}" ><i class="fa fa-book"> 历史</i></a>
        </nav>
    </div>
@endsection

@section('content')
    <div class="post post-page">
        <h1 class="post-title">关于</h1>
        <div class="post-content"><h2 id="toc_0">建刚</h2>

            <h3 id="toc_1">九五后，来自河南省濮阳市</h3>

            <h3 id="toc_2">爱自己，爱别人，乐观，世俗，有胸怀，有抱负</h3>

            <blockquote><div class="p_part">
                    <p>本博客部分图片来自互联网，</p><p>如未经版权所有者同意使用，</p><p>请联络我的邮箱1219615109@qq.com</p><p>进行协商或删除。</p></div>
            </blockquote>

           </div>
    </div>
@endsection

