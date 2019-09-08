<html>
	<head>
		<title>Viewage - @yield('title')</title>
	</head>
	<body>
		<div class="container">
			<form method="post" action="/logout">
				@csrf
				<input type="submit" value="Logout">
			</form>
			@yield('content')
		</div>
	</body>
</html>
