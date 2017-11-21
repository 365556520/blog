<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use  App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //本目录的父类
    //图片上传
    public function upload (){
        //接收上传文件用
        $file = Input::file('Filedata');
        if($file -> isValid()){
            //检验以下上传的文件是否有效
            $clientName = $file -> getClientOriginalName(); //获取文件名称
//            $tmpName = $file -> getFileName(); //缓存在tmp文件夹中的文件名 例如 php9372.tmp 这种类型
//            $realPath = $file->getRealPath();  //这个表示的是缓存在tmp文件夹下的文件的绝对路径，例如c:\wamp\tmp\php93772.tmp
            $entension = $file -> getClientOriginalExtenSion(); //上传文件的后缀
//            $mimeTye = $file->getMimeType(); //上传文件的类型 如得到结果是image/jpeg
            //比如  $nameName =md5(date('Ymdhis').mt_rand(100,999).$clientName.".".$entension);利用日期加上mt-rand(100,999)（表示三位数随机数）和客户端文件名结合使用md5算法加密得到结果，不要忘记在后面加上原始文件的的拓展名
            $newName =md5(date('Ymdhis').mt_rand(100,999).$clientName).".".$entension;
//            $path = $file -> move('storage/uploads'); //移动文件但不会改名  这样的话，默认会放置在我们 public/storage/uploads/php7908.tmp
            // $file -> move()上传成功后返回上传文件的绝对路径
            //app_path()就是app文件夹所在的路径base_path()表示根目录最外层目录并非public根目录, $newName就是新的名字可以通过某种算法获得文件名字主要是不冲突
            $path =$file -> move(base_path().'/public/uploads',$newName);
            $filePath = '/uploads/'.$newName;
            return $filePath;
        };
    }
}
