<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    //管理员主页
    public function index(){
      return view('admin.index');
    }
    public function  info(){
        return view('admin.info');
    }
   //更改超级管理员密码
    public function  pass(){
        if($input = Input::all()){
           //用数组方式设置输入框限制
            $rules = [
                //required表示password这个输入框不能为空
                //between:6,20表示密码必须在6-20位
                //confirmed判断新密码是否相同（必须在确认密码输入框的nema后缀上_confirmation）
                'password' => 'required|between:6,20|confirmed',
            ];
            //自定义消息
            $message =[
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码必须为6-20位之间',
                'password.confirmed'=>'新密码和确认密码不相同'
            ];
            //Validator认证输入
            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){
//                从数据库中取出一行信息
                 $user = User::first();
                //用Crypt解密从数据库中取出来的数据
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o']==$_password){
                    //修该数据库密码
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    //修改成功跳转到原来页面
                    return back()->with('errors','1');
                }else{
                    return back()->with('errors','2');
                }
            }else{
                //返回错误对象
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }

    }
}
