<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;
use  App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
//因为code类在public下面所以用base_path（base_path函数返回项目根目录的绝对路径）在根目录下面去找这个类
require_once public_path('org/code/Code.class.php');

class LoginController extends CommonController
{
    public function login(){
        //Input::all()能判断是否有post传送过来
        if ($input=Input::all()){
            $code = new \Code;
            $ucode = $code->get();
            if (strtoupper($input['user_code'])== $ucode){
                $user =User::first();
                if($user->user_name!=$input['user_name']||Crypt::decrypt($user->user_pass)!=$input['user_pass']){
                    return back()->with('msg','用户名或者密码输入错误');
                }else{
                    //登录成功
                    session(['user'=>$user->user_name]);
                    //route('admin')用命名路由
                    return redirect()->route('admin');
                }
            }else{

                //返回前一个页面
                return back()->with('msg','验证码输入错误');
            }
        }else{
            return view('admin.login');
        }
    }
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }


    //测试crypt加密解密
    public function crypt(){
        $str = 'aaa';
        $str1 ='eyJpdiI6IkdWam9uS0dMNlpCb21LU1wvZHJuakFnPT0iLCJ2YWx1ZSI6IjBSenZUZW94ckNmeGlubStNcWFEOGc9PSIsIm1hYyI6ImJjY2EyMTgzODRmMDM0Y2JmNjdlMWNiYTAxMDQ2ZDgyMWUwNDVkMjlkYWY3NTE2YzQ3OWUzM2RlMDViZDdlZDgifQ';
        //用Crypt::encrypt();加密
        echo Crypt::encrypt($str);
        echo '<br/>';
        //用 Crypt::decrypt();解密
        echo Crypt::decrypt($str1);
    }

    public function code(){
        //因为不是本类的对象 所以需要加\从底层去找这个对象
       $code = new \Code;
       $code->make();
    }
//   //测试获取验证码
//    public function  getCode(){
//        $code = new \Code;
//        // 测试在laravel中$_SERVER是被封装的不能直接使用所以必须要在根目录的index.php中用session_start();进行开启
//        echo $code->get();
//    }


}
