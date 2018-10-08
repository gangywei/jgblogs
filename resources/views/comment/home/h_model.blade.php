<!DOCTYPE HTML>
<html lang="{{ config('app.locale') }}">
<head>
	<title>{{config('app.name')}}</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script type="text/javascript" src="{{asset('js/home/jquery-2.0.2.min.js')}}"></script>
	<script src="{{ asset('plug/sider/jquery.sidr.min.js') }}"></script>
	<script src="{{ asset('js/admin/blog.js') }}"></script>
	{{--HTML5提出的新的元素不被IE6-8识别--}}
	<script type="text/javascript" src="{{asset('js/home/html5shiv.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/home/smartresize.js')}}"></script>

	<link rel="stylesheet" href="{{ asset('css/home/blog.css') }}">
	<link rel="stylesheet" href="{{ asset('css/home/pure-min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/home/normalize.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/home/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/home/grids-responsive-min.css') }}">
	<link rel="stylesheet" href="{{ asset('plug/sider/jquery.sidr.light.min.css') }}">
	@yield('css')
</head>
<body>

<div class="body_container">
	<header id="header" class="clearfix">
		<div class="site-name ">
			<a id="logo" href="index">Jiangang</a>
		</div>
        @section('nav')
            This is the master nav.
        @show
	</header>

	<div id="layout" class="pure-g">
		{{-- 内容框 --}}
		<div class="pure-u-1 pure-u-md-3-4">
			<div class="content_container" id="content_container">
				@yield('content')
			</div>
		</div>

		{{-- 侧边栏 --}}
		<div class="pure-u-1-4 hidden_mid_and_down" id="leftside">
			<ul id="sidebar">

				<li class="widget">
					<span class="widget-title"><strong class="fa fa-star-o"> 文章搜索</strong></span>
					<div class="widget-list">
						<form method="get" accept-charset="utf-8" action={{url("index")}} class="search-form">
							<input type="text" name="search" maxlength="20" placeholder="文章名">
						</form>
					</div>
				</li>

				<li class="widget">
					<span class="widget-title"><strong class="fa fa-star-o"> 标签云</strong></span>
					<ul class="tagcloud" id="tagscloud">
						@foreach($base['labels'] as $label)
							<li style="font-size: 15px;"><a class="category-list-link" href="/archive?label={{$label['id']}}">{{$label['title']}}</a></li>
						@endforeach
					</ul>
				</li>

				<li class="widget">
					<span class="widget-title"><strong class="fa fa-file-o"> 最新文章</strong></span>
					<ul class="post-list">
						@foreach($base['blogs'] as $blog)
							<li class="post-list-item"><a class="post-list-link"  href="/reblog/{{$blog['id']}}">{{$blog['title']}}</a></li>
						@endforeach
					</ul>
				</li>

				<li class="widget">
					<span class="widget-title"><strong class="fa fa-folder-o"> 分类</strong></span>
					<ul class="category-list">
						@foreach($base['files'] as $file)
							<li class="category-list-item"><a class="category-list-link"  href="/archive?file={{$file['id']}}">{{$file['title']}}</a></li>
						@endforeach
					</ul>
				</li>

			</ul>
		</div>


		{{-- 底部导航栏 --}}
		<div id="footer">
			<a href="/." rel="nofollow">忘眼欲川</a>
			<a rel="nofollow" target="_blank" href="http://www.miitbeian.gov.cn ">豫ICP备17012656号-1</a>
		</div>

	</div>



	<div class="sidebar-toggle" id="sidebar-toggle">
		<div class="sidebar-toggle-line-wrap">
		  <span class="sidebar-toggle-line sidebar-toggle-line-first" style="width: 100%; top: 0px; transform: rotateZ(0deg); opacity: 1; left: 0px;"></span>
		  <span class="sidebar-toggle-line sidebar-toggle-line-middle" style="width: 100%; opacity: 1; left: 0px; top: 0px; transform: rotateZ(0deg);"></span>
		  <span class="sidebar-toggle-line sidebar-toggle-line-last" style="width: 100%; top: 0px; transform: rotateZ(0deg); opacity: 1; left: 0px;"></span>
		</div>
	</div>
	<a id="rocket" class="show"></a>
	@yield('js')
	<script>
        $('#rocket').sidr({
            name: 'sidr-main',
            side: 'right',
            renaming: 'false',
            source: '#leftside'
        });
	</script>
</div>

</body>
</html>


