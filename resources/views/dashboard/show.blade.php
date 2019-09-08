@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

	<h1>{{ $site->name }}</h1>

	<table>
		<thead>
			<th>Path</th>
			<th>Views</th>
		</thead>
		<tbody>
			@foreach ($views as $view)
				<tr>
					<td>{{ $view->path }}</td>
					<td>{{ $view->total }}</td>
				</tr>
			@endforeach

		</tbody>
	</table>

@endsection
