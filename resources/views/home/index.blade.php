@extends('comment.home.h_model')

@section('nav')
    <div>
        <nav id="nav-menu" class="clearfix">
            <a href="{{url('index')}}" class="current"><i class="fa fa-home"> 首页</i></a>
            <a href="{{url('archive')}}"><i class="fa fa-archive"> 归档</i></a>
            <a href="{{url('introduce')}}" ><i class="fa fa-user"> 关于</i></a>
            <a href="{{url('history')}}"><i class="fa fa-book"> 历史</i></a>
        </nav>
    </div>
@endsection

@section('content')
    @foreach($blogs as $blog)
        <div class="post">
            <h2 class="post-title">
                <a href="./reblog/{{$blog->id}}" target="_parent">{{$blog->title}}</a>
            </h2>
            <div class="post-meta">{{date('Y-m-d',strtotime($blog->created_at))}} <span> | </span>阅读{{$blog->readnums}}</div>

            <div class="post-content">
                {{$blog->inter}}
            </div>
            <p class="readmore"><a href="{{url('reblog')}}/{{$blog->id}}">阅读更多</a></p>
        </div>
    @endforeach
    <div class="post">
        <nav class="page-navigator">
                {{ $blogs->links()}}
        </nav>
    </div>

@endsection
