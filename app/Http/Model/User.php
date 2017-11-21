<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //在Model里面设置数据库表名字和主键
    protected $table='user';
    protected $primaryKey='user_id';
    //设为假的话，表示create方法执行时，不会对create_at和updated_at修改
//    public $timestamps=false;
}
