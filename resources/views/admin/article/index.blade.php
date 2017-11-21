@extends('layouts.admin')
@section('content')
    <body>


    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;&raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <div class="result_title">
                        <h3>文章列表</h3>
                    </div>
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>文章标题</th>
                        <th>点击</th>
                        <th>作者</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->art_id}}</td>
                        <td>
                            <a href="#">{{$v->art_title}}</a>
                        </td>
                        <td>{{$v->art_view}}</td>
                        <td>{{$v->art_editor}}</td>
                        <td>{{date('y-m-d',$v->art_time)}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v->art_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <style>
        {{--调分页连接的样式--}}
        .page_list ul li span {
            padding: 6px 12px;
            text-decoration: none;
        }
    </style>
    <script>
        //删除文章
        function delArt(art_id) {
            //询问框
            layer.confirm('您确认要删除这篇文章吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                //点确认后用post异步处理
                $.post("{{url('admin/article/')}}/"+art_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data){
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

