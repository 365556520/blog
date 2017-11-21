@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;&raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
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
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">文章分类：</th>
                        <td>
                            <select name="cate_id">
                                @foreach($data as $d)
                                    <option value="{{$d->cate_id}}">{{$d->_cate_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                        </td>
                    </tr>
                    <tr>
                        <th>编辑：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" size="50" name="art_thumb">
                            {{--上传插件--}}
                            <script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <script type="text/javascript">
                                <?php $timestamp = time();?>
                                $(function() {
                                    $('#file_upload').uploadify({
                                        'buttonText' : '图片上传',
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            '_token'     : "{{csrf_token()}}"
                                        },
                                        'swf'      : "{{asset('org/uploadify/uploadify.swf')}}",
                                        'uploader' : "{{url('admin/upload')}}",
                                        'onUploadSuccess' : function(file, data, response) {
                                            $('input[name=art_thumb]').val(data);
                                            $('#art_thumb_img').attr('src',data);
//                                            alert('文件的名字' + file.name + '是否上传成功 ' + response + '文件的路径和上传成功后的名字:' + data);
                                        }
                                    });
                                });
                            </script>
                            <style>
                                .uploadify{display:inline-block;}
                                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                            </style>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            {{--显示上传缩略图--}}
                            <img src="" alt="" id="art_thumb_img" style="max-width: 350px;max-height: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag" >
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea class="lg" name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章内容：</th>
                        <td>
                            {{--这里引用了百度ueditor--}}
                            <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" name="art_content" type="text/plain" style="width:860px;height:500px;"></script>
                            <script type="text/javascript">
                            //实例化编辑器
                            //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                            var ue = UE.getEditor('editor');
                            </script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
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