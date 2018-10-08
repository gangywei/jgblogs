@extends('comment.admin.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Jian</b>Gang</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">密码重置</p>

            <form action="{{ route('chpwd') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input name="email" id="email" type="email" value="{{ old('email')  }}" class="form-control" placeholder="邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" value="{{ old('password')  }}" class="form-control" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password_confirmation" type="password" value="{{ old('password_confirmation')  }}" class="form-control" placeholder="再次输入">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <div class="row">
                        <div class="col-xs-8">
                            <input type="text" name="varify" value = "{{ old('varify')  }}" class="form-control" placeholder="邮箱验证">
                        </div>

                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="button" id="s_email" class="btn btn-primary btn-block btn-flat">发送邮件</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>

                <div class="social-auth-links text-center">
                    <button type="submit" class="btn btn-block btn-primary">密码重置</button>
                </div>

            </form>
            <a href="{{route('root')}}" class="text-center">我已经有账号啦!</a>
        </div>
        <!-- /.login-box-body -->
    </div>
@endsection

@section('js')
<script src="{{ asset('js/admin/register.js') }}"></script>
@endsection