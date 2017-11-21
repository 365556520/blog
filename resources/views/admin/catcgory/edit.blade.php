@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;&raquo;分类管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>编辑分类</h3>
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
                <a href="{{url('admin/catcgory/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/catcgory')}}"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/catcgory/'.$field->cate_id)}}" method="post">
            {{--。HTML表单只支持POST、GET两种请求方式，PUT、PATCH以及DELETE是Laravel中伪造的HTTP请求方式，--}}
            {{--需要在表单中添加<input type="hidden" name="_method" value="PUT（PATCH、DELETE）">才能生效。--}}
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="0">==顶级分类==</option>
                                @foreach($data as $d)

                                    <option value="{{$d->cate_id}}" @if($d->cate_id == $field->cate_pid)
                                    {{--数据的pid和顶级分类的id相等就选择这个顶级分类--}}
                                             selected @endif>{{$d->cate_name}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>分类名称：</th>
                        <td>
                            <input type="text" name="cate_name" value="{{$field->cate_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                        </td>
                    </tr>
                    <tr>
                        <th>分类标题：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title" value="{{$field->cate_title}}">
                            <p>标题可以写30个字</p>
                        </td>
                    </tr>

                    <tr>
                        <th>关键词：</th>
                        <td>
                            <textarea name="cate_keywords">{{$field->cate_keywords}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>详细：</th>
                        <td>
                            <textarea class="lg" name="cate_description"  value="">{{$field->cate_description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="cate_order" value='{{$field->cate_order}}'>
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