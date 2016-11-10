@extends('layouts.master')
@section('content')
	@foreach($sounds as $sound)
		<h1>{{ $sound->data }}</h1>
	@endforeach
@endsection