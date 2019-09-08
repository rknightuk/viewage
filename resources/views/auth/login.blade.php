<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form method="post" action="/login">
		@csrf
		Email: <input type="text" name="email"><br/>
		Password: <input type="password" name="password"><br/>
		<input type="submit" value="Login">
	</form>

</body>
</html>
