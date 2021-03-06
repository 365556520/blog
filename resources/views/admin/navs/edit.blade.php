@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>&raquo;&raquo;自定义导航管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>编辑自定义导航</h3>
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
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs/'.$field->nav_id)}}" method="post">
            {{--。HTML表单只支持POST、GET两种请求方式，PUT、PATCH以及DELETE是Laravel中伪造的HTTP请求方式，--}}
            {{--需要在表单中添加<input type="hidden" name="_method" value="PUT（PATCH、DELETE）">才能生效。(Laravel中提供了{{method_field('PUT')}}也可以代替前面的)--}}
            {{method_field('PUT')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" name="nav_name" value="{{$field->nav_name}}">
                            <input type="text" class="sm" name="nav_alias" value="{{$field->nav_alias}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>导航名必填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="{{$field->nav_url}}">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order"  value="{{$field->nav_order}}">
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

</body>
@endsection