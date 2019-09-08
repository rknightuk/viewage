@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

	<ul>
		@foreach ($sites as $site)
			<li><a href="/sites/{{ $site->id }}">{{ $site->name }} {{ $site->domain }}</a></li>
		@endforeach
	</ul>

	<a href="/sites/new">Create new site</a>

@endsection
