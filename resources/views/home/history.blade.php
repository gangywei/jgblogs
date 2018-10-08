@extends('comment.home.h_model')

@section('nav')
    <div>
        <nav id="nav-menu" class="clearfix">
            <a href="{{url('index')}}"><i class="fa fa-home"> 首页</i></a>
            <a href="{{url('archive')}}"><i class="fa fa-archive"> 归档</i></a>
            <a href="{{url('introduce')}}" ><i class="fa fa-user"> 关于</i></a>
            <a href="{{url('history')}}" class="current"><i class="fa fa-book"> 历史</i></a>
        </nav>
    </div>
@endsection

@section('content')
    <div class="post">
        <h1 class="post-title">历史</h1>
        <div class="post-content">
            <section id="process">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                            <div class="timeline-centered">
                                <div class="line"></div>
                                <div class="present">Now</div>
                                <div class="dot_tp"></div>
                                <div class="born">Past</div>
                                <div class="dot_bt"></div>
                                @foreach($history as $his)
                                    <div class="timeline-entry">
                                        <div class="timeline-entry-inner">
                                            <div data-wow-delay="0.2s" class="timeline-icon wow fadeInUp">
                                                <span class="number">{{$his->id}}</span>
                                            </div>
                                            <div data-wow-delay="0.2s" class="timeline-label wow fadeInUp">
                                                <span class="word">{{$his->created_at}} {{$his->contents}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection