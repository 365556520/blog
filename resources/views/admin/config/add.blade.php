@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; &raquo;配置项管理
    </div>
    <!--面包屑配置项 结束-->

	<!--结果集标题与配置项组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加配置项</h3>
            @if(count($errors)>0)
                {{--判断接受的$errors是否是对象--}}
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <script>layer.msg('{{$error}}',{icon: 5});</script>
                    @endforeach
                @else
                    <script>
                            layer.msg('{{$errors}}',{icon: 5});
                    </script>
                @endif
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置标题必填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名必填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio"  name="field_type" value="input" onclick="showTr()" checked>input　
                            <input type="radio"  name="field_type" value="textarea" onclick="showTr()">textarea　
                            <input type="radio"  name="field_type" value="radio" onclick="showTr()">radio　
                        </td>
                    </tr>
                    <tr class="field_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value">
                            <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在radio的情况下才需要配置，格式:1|开启,0|关闭</p>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea  id="" cols="30" rows="10" name="conf_tips"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        showTr();
        function showTr(){
            var type = $('input[name=field_type]:checked').val();
            if(type == 'radio'){
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
    </script>
</body>
@endsection