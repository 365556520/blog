<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class LinksController extends CommonController
{

//排序修改异步处理
    public function changeorder(){

        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $re = $links->update();
        if($re){
            $date = [
                'status'=>0,
                'msg'=>'友情连接排序更新成功'
            ];
        }else{
            $date = [
                'status'=>1,
                'msg'=>'友情连接更新失败清稍后重试'
            ];
        }
        return $date;
    }
    //全部友情链接列表 get过来的admin/Links
    public function index(){
        $date = Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('date'));
    }
    //删除友情连接 DELETE过来的admin/links/{links} 带参数
    public function destroy($link_id){
        //删除
        $re =  Links::where('link_id',$link_id)->delete();
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
    //添加友情连接 GET过来的admin/links/create
    public function create(){
        return view('admin/links/add');
    }
    //添加友情连接提交POST过来的 admin/links
    public function store(){
        $input = Input::except('_token');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'link_name' => 'required',
            'link_url' => 'required|active_url',
            'link_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'link_name.required'=>'友情连接名称不能不能为空',
            'link_url.required'=>'友情链接URL不能不能为空',
            'link_order.required'=>'排序不能为空',
            'link_order.integer'=>'排序只能为整数',
            'link_url.active_url'=>'友情链接URL格式不正确',
        ];
        //Validator认证输入

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //写入数据库因为提交的数据有保护字段所以需要在模型里面设置
            //用create提交时候需要在 模型中设置 protected $guarded=[];
            $re =Links::create($input);
            if($re){
                //如果不为空
                return redirect('admin/links');
            }else{
                return back()->with('errors','数据填充失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    //编写友情链接 GET过来的admin/links/{links}/edit 带参数
    public function edit($link_id){
        $field = Links::find($link_id);
        return view('admin/links/edit',compact('field'));
    }
    //更新友情连接 PUT过来的admin/links/{links} 带参数
    public function update($link_id){
        $input = Input::except('_token','_method');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'link_name' => 'required',
            'link_url' => 'required|active_url',
            'link_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'link_name.required'=>'友情链接名称不能为空',
            'link_order.required'=>'友情链接排序不能为空',
            'link_order.integer'=>'友情链接排序只能为整数',
            'link_url.required'=>'友情链接URL不能为空',
            'link_url.active_url'=>'友情链接URL格式不正确',
        ];

        //Validator认证输入
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re =Links::where('link_id',$link_id)->update($input);
            if($re){
                //如果不为空
                return redirect('admin/links');
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
