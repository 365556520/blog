<?php

namespace  App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ArticleController extends CommonController
{
    //全部文章列表 get.admin/article
    public function index(){
        $data = Article::orderBy('art_id','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    //添加文章 get.admin/article/create
    public function create(){
        //获得分类
        $data =(new Category)->tree();
        return view('admin.article.add',compact('data'));
    }
    //添加文章提交 post.admin/article
    public function  store(){
       $input=Input::except('_token');
       $input['art_time']=time();//添加创建时间
        //用数组方式设置输入框限制

        $rules = [
            'art_title' => 'required', //文章名称不能为空
            'art_content' => 'required'//文章内容不能为空

        ];
        //自定义消息
        $message =[
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空'
        ];
        //Validator认证输入
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //写入数据库因为提交的数据有保护字段所以需要在模型里面设置
            //用create提交时候需要在 模型中设置 protected $guarded=[];
            $re=Article::create($input);
            if($re){
                //如果不为空
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章添加失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }


    }
    //编修改文章  GET过来的admin/article/{article}/edit 带参数
    public function edit($art_id){
        //获得分类
        $data =(new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }
    //更新文章 PUT过来的admin/article/{article} 带参数
    public function update($art_id){
        $input = Input::except('_token','_method');
        $rules = [
            'art_title' => 'required', //文章名称不能为空
            'art_content' => 'required'//文章内容不能为空

        ];
        //自定义消息
        $message =[
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空'
        ];
             //Validator认证输入
         $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re =Article::where('art_id',$art_id)->update($input);
            if($re){
                //如果不为空
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章更改失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }

    //删除当个文章 DELETE过来的admin/article/{article} 带参数
    public function destroy($art_id){
        //删除
        $re =  Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'文章删除失败！'
            ];
        }
        return $data;
    }

}
