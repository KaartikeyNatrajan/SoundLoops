@extends('layouts.master')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/keys.css') }}">
@endsection
@section('content')
	<progress id="timer" value="0"></progress>
	<br><br><br>
	<div class="wrapper">
		<div class="mainArea">
			<table id="drumTable" class="sounds">

			</table>
			<h1>Drums</h1>
		</div>
		<div class="mainArea">
			<table id="leadTable" class="sounds">

			</table>
			<h1>Lead</h1>
		</div>
		<div class="mainArea">
			<table id="bassTable" class="sounds">

			</table>
			<h1>Bass</h1>
		</div>
	</div>
	<div class="wrapper">
		@include('keys')
	</div>
@endsection
@section('scripts')
	<script type="text/javascript" src="{{ asset('js/main2.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/play.js') }}"></script>
@endsection