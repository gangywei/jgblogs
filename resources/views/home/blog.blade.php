@extends('comment.home.h_model')

@section('css')
    {{--fancyBox是一款优秀的弹出框Jquery插件--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plug/fancybox/jquery.fancybox.min.css') }}">
@endsection

@section('nav')
    <div>
        <nav id="nav-menu" class="clearfix">
            <a href="{{url('index')}}" class="current"><i class="fa fa-home"> 首页</i></a>
            <a href="{{url('archive')}}"><i class="fa fa-archive"> 归档</i></a>
            <a href="{{url('introduce')}}" ><i class="fa fa-user"> 关于</i></a>
            <a href="{{url('history')}}" ><i class="fa fa-book"> 历史</i></a>
        </nav>
    </div>
@endsection

@section('content')
    <article class="post">
        <header>
            <h1 class="post-title">{{$blog->title}}</h1>
        </header>

        <div class="post-meta">
            {{$blog->created_at}}
            <span> | </span>
            阅读 <i class="fa fa-star-o">{{$blog->readnums}}</i>
             <span> | </span>
            <span class="category">
                <a href="{{url('archive')}}?file={{$blog->file['id']}}">{{$blog->file['title']}}</a>
            </span>
        </div>
        <div class="post-content">
            @php echo $blog->contents @endphp
        </div>
        <a class="article-share-link">分享到</a>

        {{--文章标签云--}}
        <div class="tags">
            @foreach($blog->labels as $label)
                <a href="{{url('archive')}}?label={{$label->id}}">{{$label->title}}</a>
            @endforeach
        </div>

        {{--上下文章链接--}}
        <div class="post-nav">
            @if(isset($before['0']))
                <a href="{{url('reblog')}}/{{$before['0']->id}}" class="pre">{{$before['0']->title}}</a>
            @endif
            @if(isset($after['0']))
                <a href="{{url('reblog')}}/{{$after['0']->id}}" class="next">{{$after['0']->title}}</a>
            @endif
        </div>
    </article>


<!--PC版-->
<div class="post">
    <div id="SOHUCS" sid="{{$blog->id}}"></div>
</div>
<script charset="utf-8" type="text/javascript" src="https://changyan.sohu.com/upload/changyan.js" ></script>
<script type="text/javascript">
window.changyan.api.config({
    appid: 'cysXvdURh',
    conf: 'prod_5979fb84ca61643ab172b22d4e508bf9'
});
</script>

@endsection

@section('js')
    <script src="{{ asset("plug/fancybox/jquery.fancybox.min.js") }}"></script>
    <script>
        $(document).ready(function(){
            $().fancybox({
                selector : 'article p>img',
                loop     : true,
                toolbar  : true,
                smallBtn : true,
                infobar : true,
            });
        });
    </script>
@endsection
