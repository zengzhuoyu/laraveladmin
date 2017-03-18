<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title','Laravel rumen') - Laravel 入门教程</title>
	<link rel="stylesheet" href="/css/app.css">
</head>
<body>
	<!-- 导航栏 -->
	@include('layouts.header')

	<div class="container">
		<div class="col-md-offset-1 col-md-10">
			@yield('content')
			@include('layouts.footer')
		</div>
	</div>
</body>
</html>