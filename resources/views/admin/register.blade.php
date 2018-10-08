@extends('comment.admin.auth')
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href="../../index2.html"><b>Jian</b>Gang</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">注册账号</p>

            <form action="{{url('Admin/register')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input type="text" name="name" class="form-control" placeholder="Full name">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" name="email" value = "{{ old('email')}}"  class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" value = "{{old('password')}}"  class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password_confirmation" value = "{{old('password_confirmation')}}"  class="form-control" placeholder="Retype password">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label class="">
                                <input type="checkbox">我同意<a href="#">规则</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
                    </div>
                    <!-- /.col -->
                </div>
                <a href="{{route('root')}}" class="text-center">我已经有账号啦</a>
            </form>
        </div>
        <!-- /.form-box -->
    </div>
@endsection