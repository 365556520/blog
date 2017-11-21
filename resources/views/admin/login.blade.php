<!DOCTYPE html >
<html >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
	<title>后台登录</title>
	<link href="{{asset('adminlogin/css/bootstrap.min.css')}}" title="" rel="stylesheet" />
	<link title="orange" href="{{asset('adminlogin/css/login.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div style="height:1px;"></div>
	<div class="login">
		<header>
			<h1>系统后台管理平台</h1>
		</header>
		<div class="sr">
				@if(session('msg'))
					<p style="color:red">{{session('msg')}}</p>
				@endif
				<form action="" method="post">
					{{--//添加csrf认证--}}
					{{csrf_field()}}
					<div class="name">
						<label>
							<i class="sublist-icon glyphicon glyphicon-user"></i>
						</label>
						<input type="text"  placeholder="这里输入登录名" name="user_name" class="name_inp">
					</div>
					<div class="name">
						<label>
							<i class="sublist-icon glyphicon glyphicon-pencil"></i>
						</label>
						<input type="password" name="user_pass" placeholder="这里输入登录密码" class="name_inp">
					</div>
					<div  style="position:relative;margin-bottom:20px;clear:both;border:0px solid;width: 100%;height: 40px;">
						<input type="text" name="user_code"/>
						{{--//在laravel中提供了url 做地址引用
						 onclick事件中有的浏览器会认为是同意个地址导致不重新请求所以在地址后面加个随机数让浏览器认为地址不同而--}}
						<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
					</div>
					<button class="dl" type="submit">立即登陆</button>
				</form>
		</div>
	</div>
</body>
</html>