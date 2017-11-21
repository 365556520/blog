<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //在Model里面设置数据库表名字和主键
    protected $table='category';
    protected $primaryKey='cate_id';
    //设为假的话，表示create方法执行时，不会对create_at和updated_at修改
    public $timestamps=false;
    //排除不能填冲的字段
    protected $guarded=[];
    public function tree(){
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,'cate_name','cate_id','cate_pid',0);
    }
    //这个类处理树型列表参数说明：$date数据，$field_id父数据表头名,$field_pid子数据表头名，$pid父数据中的pid的值
    public function getTree($date,$field_name,$field_id='id',$field_pid='pid',$pid=0){
        $arr = array();
        //遍历数据
        foreach ($date as $k=>$v){
            if($v->$field_pid==$pid) {
                $date[$k]["_".$field_name] =  $date[$k][$field_name];
                //如果该数据的cate_pid=0也就是总栏目的时候就把该数据添加在$arr[]
                $arr[] = $date[$k];
                //然后从新遍历数据
                foreach ($date as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        $date[$m]["_".$field_name] ='├─ '.$date[$m][$field_name];
                        //如果该数据的cate_pid=cate_id也就是子栏目cate_pid等于总栏目的cate_id的时候就把该数据添加在$arr[]
                        $arr[] = $date[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
