@extends('layouts.admin')
@section('content')
<body style="background:#F3F3F4;">
<div class="login_box">
	<h1>blog</h1>
	<h2>欢迎使用系统后台管理平台</h2>
	<div class="form">
		@if(session('msg'))
		<p style="color:red">{{session('msg')}}</p>
		@endif
		<form action="" method="post">
			{{--//添加csrf认证--}}
			{{csrf_field()}}
			<ul>
				<li>
					<input type="text" name="user_name" class="text"/>
					<span><i class="fa fa-user"></i></span>
				</li>
				<li>
					<input type="password" name="user_pass" class="text"/>
					<span><i class="fa fa-lock"></i></span>
				</li>
				<li>
					<input type="text" class="code" name="user_code"/>
					<span><i class="fa fa-check-square-o"></i></span>
					{{--//在laravel中提供了url 做地址引用
					 onclick事件中有的浏览器会认为是同意个地址导致不重新请求所以在地址后面加个随机数让浏览器认为地址不同而--}}
					<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">

				</li>
				<li>
					<input type="submit" value="立即登陆"/>
				</li>
			</ul>
		</form>
		<p><a href="#">返回首页</a> &copy; 2017 Powered by </p>
	</div>
</div>
</body>
@endsection