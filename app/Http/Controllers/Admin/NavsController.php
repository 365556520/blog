<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class NavsController extends CommonController
{

//排序修改异步处理
    public function changeorder(){

        $input = Input::all();
        $navs = Navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $re = $navs->update();
        if($re){
            $date = [
                'status'=>0,
                'msg'=>'自定义导航排序更新成功'
            ];
        }else{
            $date = [
                'status'=>1,
                'msg'=>'自定义导航更新失败清稍后重试'
            ];
        }
        return $date;
    }
    //全部友情链接列表 get过来的admin/navs
    public function index(){
        $date = Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index',compact('date'));
    }
    //删除自定义导航 DELETE过来的admin/navs/{navs} 带参数
    public function destroy($nav_id){
        //删除
        $re =  Navs::where('nav_id',$nav_id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'分类删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'分类删除失败！'
            ];
        }
        return $data;
    }
    //添加自定义导航 GET过来的admin/navs/create
    public function create(){
        return view('admin/navs/add');
    }
    //添加自定义导航提交POST过来的 admin/navs
    public function store(){
        $input = Input::except('_token');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'nav_name' => 'required',
            'nav_url' => 'required|active_url',
            'nav_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'nav_name.required'=>'自定义导航名称不能不能为空',
            'nav_url.required'=>'友情链接URL不能不能为空',
            'nav_order.required'=>'排序不能为空',
            'nav_order.integer'=>'排序只能为整数',
            'nav_url.active_url'=>'友情链接URL格式不正确',
        ];
        //Validator认证输入

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //写入数据库因为提交的数据有保护字段所以需要在模型里面设置
            //用create提交时候需要在 模型中设置 protected $guarded=[];
            $re =Navs::create($input);
            if($re){
                //如果不为空
                return redirect('admin/navs');
            }else{
                return back()->with('errors','数据填充失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    //编写友情链接 GET过来的admin/navs/{navs}/edit 带参数
    public function edit($nav_id){
        $field = Navs::find($nav_id);
        return view('admin/navs/edit',compact('field'));
    }
    //更新自定义导航 PUT过来的admin/navs/{navs} 带参数
    public function update($nav_id){
        $input = Input::except('_token','_method');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'nav_name' => 'required',
            'nav_url' => 'required|active_url',
            'nav_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'nav_name.required'=>'友情链接名称不能为空',
            'nav_order.required'=>'友情链接排序不能为空',
            'nav_order.integer'=>'友情链接排序只能为整数',
            'nav_url.required'=>'友情链接URL不能为空',
            'nav_url.active_url'=>'友情链接URL格式不正确',
        ];

        //Validator认证输入
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re =Navs::where('nav_id',$nav_id)->update($input);
            if($re){
                //如果不为空
                return redirect('admin/navs');
            }else{
                return back()->with('errors','数据更改失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    public function show(){

    }

}
