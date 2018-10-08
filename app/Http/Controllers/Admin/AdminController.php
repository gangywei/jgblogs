<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminController extends Controller{
    public function root(){
        if(!empty($_COOKIE['userid'])){
            $id = $_COOKIE['userid'];
            $user = json_decode(Redis::get($id),true);
            if(!empty($user)){
                if($user['remember']){
                    Auth::loginUsingId($user['id']);
                    Redis::expire($id,7200);
                    return redirect('blog');
                }else{
                    Redis::expire($id,7200);
                    return view('admin.root',['user' => $user]);
                }
            }
        }
        return view('admin.root');
    }

    public function login(Request $request){
        $privateKey = "-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAOvgMGQ4QRd397P0
WVTZFGATQwfbt1HqgIbMbKLfHcdWGk5iIKe4J0b1iQjLPN2qAglu0WFh5AqoDTy/
YdgFpRqxCEoYVQOxTvLp0VdrxU4eqQFkbLKDAqymWHiBlQmXlWMmhlSm1x772Si6
DmlCrml/3CgVh4ZPNxDdJR1R/0EBAgMBAAECgYAZjcQwV1fV7w1K1aIH6yyl6/BL
HaaSnVEnSWZLjthvDAj1jPP0t6KpsVgTN9F0QkLOOs88OZq2/NXSSvmSqanlMSEA
/jcpQh1RZnl3wKveUuMIOT7eMgXrSkw0nS7utpDQ8Qdral6z09vim0VycGkoY8qk
ZfSSGmCsmjlQutx18QJBAPkSoLYcAFixcqXrTU0Ef2+jkv6f6+4/0a1Z3z1m3Tsv
WZNSY2GS9Sjb+7PuaZyOWlp0XczjtaQ07YJYr7ceNicCQQDyb5mMCuFDUjufFv7w
Ca1pmZUvK9cih9Hg7VS1js7ZUJDKt3W/yAzjAiKGoLruQKAO8PEPDx3d0dwAu5ds
ijCXAkEA3dmPuGV8kYOMwOizc7Rb5g5msdG0DgReOO/h/gkPaNYmDSjHSHPjVj+L
FJt5Cm9pX0RjAEqa0eYq330rFgoc5QJBAIe5dsryJF6eIQbVxu/3WwAtnVmFP7Hz
O8qi07O5OZBsDEORJfiyNJS6Uz3vqfdMcs8qkKoPmnbe0D4Qx5taWg0CQQDTstPw
055Q9RiUcCUay5XS2AwDt3DlhmV3xb4STv3fEgSfbians9I7Y8E8wAzsQ9CLGW62
kVfW1J8eRi0tR/pX
-----END PRIVATE KEY-----";
        $key = openssl_pkey_get_private($privateKey);
        $rem = false;
        if($request->remember=='true')
            $rem = true;
        $email = $request->input('email');
        $pass = $request->input('password');
        if(!empty($email)&&!empty($pass)){
            $pattern = '/([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})/';
            if(!preg_match( $pattern, $email ))
                return response()->json([
                    'res' => '邮箱格式错误'
                ]);
        }else{
            return response()->json([
                'res' => '密码或邮箱错误，请检查'
            ]);
        }
        openssl_private_decrypt(base64_decode($pass),$passwd,$key);
        if (Auth::attempt(['email' => $email, 'password' =>$passwd],$rem)) {
            if($rem){
                $userdata = json_encode(['email'=>$email,'passwd'=>$passwd,'remember'=>true,'id'=>Auth::id()]);
                if(empty($_COOKIE['userid'])){
                    $loop = md5(time().mt_rand(1,1000000));
                    setcookie('userid',$loop,time()+7200);
                }else{
                    $loop = $_COOKIE['userid'];
                    $res = Redis::del($loop);
                }
                Redis::set($loop,$userdata);
                Redis::expire($loop,7200);
            }
            return response()->json([
                'res' => true,
            ]);
        }else{
            return response()->json([
                'res' => '密码或邮箱错误'
            ]);
        }
    }

    //注册页面方法
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|max:10|confirmed',
        ],$this->varify(0),$this->varify(1));
        $res = User::create($request->all());
        if($res)
            return redirect()->back()
                ->withErrors(array('账号注册成功'))->withInput();
    }

    //发送邮件到用户
    public function s_email(Request $request){
        $varify = mt_rand(1000,9999);
        Redis::set($request->email,$varify);
        Redis::expire($request->email,300);
        Mail::to('1219615109@qq.com')->send(new OrderShipped('你的验证码是'.$varify."时间期限5分钟"));
    }
    //密码重置
    public function chpwd(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|max:10|confirmed',
            'varify' => 'required',
        ],$this->varify(0),$this->varify(1));
        if($request->varify==Redis::get($request->email)){
            $flight =User::where('email', $request->email)->first();
            $flight->password = $request->password;
            $result = $flight->save();
            if($result){
                Redis::del($request->email);
                return redirect('root')
                    ->withErrors(array('重置密码成功'))->withInput();
            }else{
                return redirect()->back()
                    ->withErrors(array('更改数据失败'))->withInput();
            }
        }else{
            return redirect()->back()
                ->withErrors(array('重置密码失败'))->withInput();
        }
    }

    //表单验证信息
    public function varify($var){
        if($var===0){
            return [
                'confirmed'=>':attribute 不一致',
                'required'=>':attribute 为必填项',
                'email'=>':attribute 格式不对',
                'max'=>':attribute 长度超出范围'
            ];
        }else{
            return [
                'name'=>'姓名',
                'email'=>'邮箱',
                'password'=>'密码'
            ];
        }
    }
    //退出登录
    public function logout(){
        if(!empty($_COOKIE['userid'])){
            $id = $_COOKIE['userid'];
            $user = json_decode(Redis::get($id),true);
            $user['remember'] = false;
            $res = Redis::del($id);
            if($res){
                Redis::set($id,json_encode($user));
                Redis::expire($id,7200);
            }
        }
        Auth::logout();
        return redirect('root');
    }
}
