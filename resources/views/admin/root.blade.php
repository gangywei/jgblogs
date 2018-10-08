@extends('comment.admin.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Jian</b>Gang</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">管理登陆界面</p>

            <form  method="post"  onsubmit="return false;">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input name="email" type="email" id="email" value="{{$user['email'] or ""}}" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" id="passwd" value="{{$user['passwd'] or ""}}" type="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck" id="repass">
                            <label>
                                <input name="remember" type="checkbox"> 记住密码
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="button" id="login" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div>
                </div>
            </form>

            <a href="{{route('find')}}">忘记密码</a><br>
            <a href="#" class="text-center">注册账号</a>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/jsencrypt.min.js') }}"></script>
    <script src="{{ asset('js/admin/login.js') }}"></script>
@endsection