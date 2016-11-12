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
			<table id="bassTable" class="sounds">

			</table>
			<h1>Bass</h1>
		</div>
	</div>
	<div class="wrapper text-center">
		@include('keys')
	</div>

	<div class="wrapper" id="record">
		<button v-if="!recording" class="btn btn-lg" style="background-color:red" @click="toggle">Record</button>
		<button v-else class="btn btn-lg" style="background-color:yellow" @click="toggle">Stop</button>
		<button v-if="completed" class="btn btn-lg btn-success" @click="saveSound">Save</button>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript" src="{{ asset('js/main2.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/play.js') }}"></script>
	<script type="text/javascript">
		var recorder = new Vue({
		el: '#record',
		data: {
			recording: false,
			jsonData : null,
			completed : false
		},
		methods: {
			toggle: function() {
				this.recording = !this.recording;
				
				if(this.recording)
				{
					startTimer();
				}
				else
				{
					this.jsonData = finishRecording();
					this.completed = true;
				}
			},
			saveSound: function() {
				vm = this;
				this.$http.post('/create',{
					'_token': Laravel.csrfToken,
					'jsonData': vm.jsonData
				}).then((response) => {
					console.log(response);
					alert("successfully saved");
					window.location.href = "/";
							
				});
			}
		}
		
	})
	</script>
@endsection