@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;&raquo;分类管理
    </div>
    <!--面包屑导航 结束-->

	{{--<!--结果页快捷搜索框 开始-->--}}
	{{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    {{--<!--结果页快捷搜索框 结束-->--}}

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <div class="result_title">
                        <h3>分类列表</h3>
                    </div>
                    <a href="{{url('admin/catcgory/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="{{url('admin/catcgory')}}"><i class="fa fa-recycle"></i>全部分类</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>

                    @foreach($date as $v)
                        <tr>
                            <td class="tc">
                                {{--//传过去2个参数 this一个本对象另外一个是 当前的id--}}
                                <input type="text" onchange="changeOrder(this,{{$v->cate_id}})" value="{{$v->cate_order}}">
                            </td>
                            <td class="tc">{{$v->cate_id}}</td>
                            <td>
                                <a href="#">{{$v->_cate_name}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v->cate_title}}</a>
                            </td>
                            <td>{{$v->cate_view}}</td>
                            <td>
                                <a href="{{url('admin/catcgory/'.$v->cate_id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delCate({{$v->cate_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<script>
    //修改排序
    function changeOrder(obj,cate_id) {
        //获取这个对象的里面填写的值
        var cate_order = $(obj).val();
        //jq中post异步请求参数一是 要发送的地址 二是发送的数据 三是执行函数
        $.post('{{url('admin/cate/changeorder')}}',{'_token':'{{csrf_token()}}','cate_id':cate_id,'cate_order':cate_order},function (date) {
            if(date.status == 0){
                layer.msg(date.msg,{icon:6});
            }else {
                layer.msg(date.msg,{icon:5});
            }
        });
    }
    //删除分类
    function delCate(cate_id) {
        //询问框
        layer.confirm('您确认要删除这个分类吗？', {
            btn: ['确认','取消'] //按钮
        }, function(){
            //点确认后用post异步处理
            $.post("{{url('admin/catcgory/')}}/"+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data){
                if(data.status==0){
                    layer.msg(data.msg, {icon: 6});
                    //删除后延迟500毫秒刷新
                    setTimeout('location.href = location.href',500);
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }, function(){
            //点取消
        });
    }
</script>
</body>
@endsection