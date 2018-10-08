@extends('comment.home.h_model')

@section('nav')
    <div>
        <nav id="nav-menu" class="clearfix">
            <a href="{{url('index')}}"><i class="fa fa-home"> 首页</i></a>
            <a href="{{url('archive')}}" class="current"><i class="fa fa-archive"> 归档</i></a>
            <a href="{{url('introduce')}}" ><i class="fa fa-user"> 关于</i></a>
            <a href="{{url('history')}}" ><i class="fa fa-book"> 历史</i></a>
        </nav>
    </div>
@endsection

@section('content')
    @if(!empty($title))
        <h1 class="label-title">{{$title}}</h1>
    @endif

    @if(!empty($blogs))
        @foreach($blogs as $blog)
                <div class="post-archive">
                    <h2>{{$blog[0]['date']}}</h2>
                    <ul class="listing">
                        @foreach($blog as $bg)
                            <li>
                                <span class="date">{{date('Y-m-d',strtotime($bg["created_at"]))}}</span>
                                <a href="./reblog/{{$bg['id']}}" title="{{$bg['title']}}" target="_parent">{{$bg['title']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
        @endforeach
    @endif

@endsection