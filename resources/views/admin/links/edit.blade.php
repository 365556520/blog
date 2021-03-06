@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;&raquo;友情链接管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>编辑友情链接</h3>
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
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部友情链接</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/links/'.$field->link_id)}}" method="post">
            {{--。HTML表单只支持POST、GET两种请求方式，PUT、PATCH以及DELETE是Laravel中伪造的HTTP请求方式，--}}
            {{--需要在表单中添加<input type="hidden" name="_method" value="PUT（PATCH、DELETE）">才能生效。(Laravel中提供了{{method_field('PUT')}}也可以代替前面的)--}}
            {{method_field('PUT')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>友情链接名称：</th>
                        <td>
                            <input type="text" name="link_name" value="{{$field->link_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                        <td>
                            <input type="text" class="lg" name="link_url" value="{{$field->link_url}}">
                        </td>
                    </tr>
                    <tr>
                        <th>友情链接标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title"  placeholder="这里输入标题" value="{{$field->link_title}}">
                            <span>标题可以写30个字</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="link_order"  value="{{$field->link_order}}">
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