<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ConfigController extends CommonController
{
//排序修改异步处理
    public function changeorder(){
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();
        if($re){
            $date = [
                'status'=>0,
                'msg'=>'配置项排序更新成功'
            ];
        }else{
            $date = [
                'status'=>1,
                'msg'=>'配置项更新失败清稍后重试'
            ];
        }
        return $date;
    }
    //全部配置项接列表 get过来的admin/config
    public function index(){
        $date = Config::orderBy('conf_order','asc')->get();
        foreach ($date as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    //把name="conf_content[]"设置称数组就不会被后面的覆盖
                    $date[$k]->_html='<input type="text" name="conf_content[]" class="lg" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $date[$k]->_html='<textarea type="text"  class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                   //$v->field_value的值1|开启,0|关闭，用explode函数以逗号为间隔把这个字符串拆分开，返回一个数组
                   $arr = explode(',',$v->field_value);
                   $str = '';
                    foreach ($arr as $m=>$n){
                       $r = explode('|',$n);
                       $c = $v->conf_content==$r[0]?'checked':'';

                        $str.= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $date[$k]->_html= $str;
                    break;
            }
        }
        return view('admin.config.index',compact('date'));
    }
    //删除配置项 DELETE过来的admin/config/{config} 带参数
    public function destroy($conf_id){
        //删除
        $re =  Config::where('conf_id',$conf_id)->delete();
        if($re){
            //把删除后新的数据从数据库中写到配置文件中
            $this->putFile();
            $data = [
                'status'=>0,
                'msg'=>'配置项删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'配置项删除失败！'
            ];
        }
        return $data;
    }
    //添加配置项 GET过来的admin/config/create
    public function create(){
        return view('admin/config/add');
    }
    //添加配置项提交POST过来的 admin/config
    public function store(){
        $input = Input::except('_token');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'conf_name' => 'required',
            'conf_title' => 'required',
            'conf_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'conf_name.required'=>'配置项名称不能为空',
            'conf_title.required'=>'配置项标题不能为空',
            'conf_order.required'=>'排序不能为空',
            'conf_order.integer'=>'排序只能为整数',

        ];
        //Validator认证输入

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //写入数据库因为提交的数据有保护字段所以需要在模型里面设置
            //用create提交时候需要在 模型中设置 protected $guarded=[];
            $re =Config::create($input);
            if($re){
                //如果不为空
                return redirect('admin/config');
            }else{
                return back()->with('errors','数据填充失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    //编写配置项 GET过来的admin/config/{config}/edit 带参数
    public function edit($conf_id){
        $field = Config::find($conf_id);
        return view('admin/config/edit',compact('field'));
    }
    //更改配置项 PUT过来的admin/config/{config} 带参数
    public function update($conf_id){
        $input = Input::except('_token','_method');
        //用数组方式设置输入框限制
        $rules = [
            //required表示password这个输入框不能为空
            'conf_name' => 'required',
            'conf_title' => 'required',
            'conf_order' => 'required|integer',
        ];
        //自定义消息
        $message =[
            'conf_name.required'=>'配置项名称不能为空',
            'conf_title.required'=>'配置项标题不能为空',
            'conf_order.required'=>'排序不能为空',
            'conf_order.integer'=>'排序只能为整数',

        ];
        //Validator认证输入
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re =Config::where('conf_id',$conf_id)->update($input);
            if($re){
                //如果不为空
                //把更新的数据从数据库中写到配置文件中
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->with('errors','数据更改失败，请稍候重试!');
            }
        }else{
            //返回错误对象
            return back()->withErrors($validator);
        }
    }
    //修改网站项的值
    public function changeContent(){
       $input = Input::all();
       //得到2个数组一个是ID数组和值数组
       foreach ($input['conf_id'] as $k =>$v){
           Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
       }
       //把更新的数据从数据库中写到配置文件中
       $this->putFile();
        return  back()->with('errors','数据更改成功');
    }
    //把数据库配置项写到文件里面
    public function putFile(){
       // echo \Illuminate\Support\Facades\Config::get('web.web_count'); //获取文件内数组的值
        //从数据库中得到这个2个字段的数值all();就是一个纯净的数组了
        $config = Config::pluck('conf_content','conf_name')->all();
        //base_path()是根目录找到\config\web.php的文件没有会自己创建这个文件
        $path =  base_path().'\config\web.php';
        //把数组转换成字符串用var_export($config,true);
        $str = '<?php return '.var_export($config,true).';';
        //写到文件里面 用file_put_contents($path,$str);第一个是路径第二个字符串是内容
        file_put_contents($path,$str);
    }
    //显示
    public function show(){

    }

}
