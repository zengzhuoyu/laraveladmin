<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title','Laravel rumen') - Laravel 入门教程</title>
	<link rel="stylesheet" href="/css/app.css">
</head>
<body>
	<!-- 导航栏 -->
	<header class="navbar navbar-fixed-top navbar-inverse">
	  <div class="container">
	    <div class="col-md-offset-1 col-md-10">
	      <a href="/" id="logo">Sample App</a>
	      <nav>
	        <ul class="nav navbar-nav navbar-right">
	          <li><a href="/help">帮助</a></li>
	          <li><a href="#">登录</a></li>
	        </ul>
	      </nav>
	    </div>
	  </div>
	</header>

	<div class="container">
		@yield('content')
	</div>
</body>
</html>