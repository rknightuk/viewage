@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

	<form method="post" action="/sites/new">
		@csrf
		Site name: <input type="text" name="name"><br/>
		Domain: <input type="text" name="domain"><br/>
		<input type="submit" value="Create Site">
	</form>

@endsection
