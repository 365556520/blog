<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CatcgoryController extends CommonController
{   //排序修改异步处理
    public function changeorder(){
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            $date = [
                'status'=>0,
                'msg'=>'分类排序更新成功'
            ];
        }else{
            $date = [
                'status'=>1,
                'msg'=>'分类排序更新失败清稍后重试'
            ];
        }
        return $date;
    }
    //全部分类列表 get过来的admin/catcgory
    public function index(){
        //原始创建方法
//        $categorys = new Category();
//        $date = $categorys->tree();
        //新学的创建方法
        $date =(new Category)->tree();
      return view('admin.catcgory.index')->with('date',$date);
    }
    //添加分类提交POST过来的admin/catcgory
    public function store(){
        $input = Input::except('_token');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'cate_name' => 'required',
            'cate_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'cate_name.required'=>'分类不能为空',
            'cate_order.required'=>'分类排序不能为空',
            'cate_order.integer'=>'分类排序只能为整数',
        ];
        //Validator认证输入
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //写入数据库因为提交的数据有保护字段所以需要在模型里面设置
            //用create提交时候需要在 模型中设置 protected $guarded=[];
            $re =Category::create($input);
            if($re){
                //如果不为空
                return redirect('admin/catcgory');
            }else{
                return back()->with('errors','数据填充失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    //GET过来的admin/catcgory/create  添加分类中的顶级分类
    public function create(){
        $data = Category::where('cate_pid',0)->get();
        return view('admin/catcgory/add',compact('data'));
    }
    //GET过来的admin/catcgory/{catcgory}/edit 带参数  编写分类
    public function edit($cate_id){
       $field = Category::find($cate_id);
       $data = Category::where('cate_pid',0)->get();
       return view('admin/catcgory/edit',compact('field','data'));
    }
    //PUT过来的admin/catcgory/{catcgory} 带参数  更新分类
    public function update($cate_id){
        $input = Input::except('_token','_method');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'cate_name' => 'required',
            'cate_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'cate_name.required'=>'分类不能为空',
            'cate_order.required'=>'分类排序不能为空',
            'cate_order.integer'=>'分类排序只能为整数',
        ];

        //Validator认证输入
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re =Category::where('cate_id',$cate_id)->update($input);
            if($re){
                //如果不为空
                return redirect('admin/catcgory');
            }else{
                return back()->with('errors','数据更改失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    //GET过来的admin/catcgory/{catcgory} 带参数  显示单个分类信息
    public function show(){

    }
    //DELETE过来的admin/catcgory/{catcgory} 带参数  删除分类
    public function destroy($cate_id){
        //删除
       $re =  Category::where('cate_id',$cate_id)->delete();
       //看这个表中有子分类没 如果有就把子分类pid改成顶级分类
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
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
}
