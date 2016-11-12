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
	<div id="record">
		<div class="wrapper text-center">
			<button class="btn btn-primary" @click="toggleInstrumentDown"> < </button>
			@include('keys')
			<button class="btn btn-primary" @click="toggleInstrumentUp"> > </button>
		</div>

		<div class="wrapper">
			<button v-if="!recording" class="btn btn-lg" style="background-color:red" @click="toggle">Record</button>
			<button v-else class="btn btn-lg" style="background-color:yellow" @click="toggle">Stop</button>
			<button v-if="completed" class="btn btn-lg btn-success" @click="saveSound">Save</button>
		</div>
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
			completed : false,
			instrument : 0,
			keymap : {
				'A' : 4,
				'S' : 5,
				'D' : 6,
				'F' : 7,
				'G' : 8,
				'H' : 9,
				'J' : 10,
				'K' : 11,
				'L' : 12,
				'Z' : 13,
				'X' : 14,
				'C' : 15,
				'V' : 16,
			},
			alreadyPlaying: []
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
			},
			toggleInstrumentUp: function() {
				this.instrument += 1;
			},

			toggleInstrumentDown: function() {
				if(this.instrument > 0)
				{
					this.instrument -= 1;
				}
			},
			playKey: function(event)
			{
				var key = event.keyCode;
				var char = String.fromCharCode(key);
				if(this.alreadyPlaying.indexOf(char) < 0)
				{
					play(this.keymap[char] + ( 13 * this.instrument ) );
					this.alreadyPlaying.push(char);
				}
				
			},
			pauseKey: function(event)
			{
				var key = event.keyCode;
				var char = String.fromCharCode(key);
				pauseit(this.keymap[char] + ( 13 * this.instrument ) );
				this.alreadyPlaying.splice(this.alreadyPlaying.indexOf(char),1);
			}
		}
		
	});

	function noteClick(note)
	{
		// console.log(noteId);
		noteId = parseInt(note.id.match(/\d+/)[0]) + 3;
		play(noteId);
	}

	document.body.addEventListener("keydown", recorder.playKey);
	document.body.addEventListener("keyup", recorder.pauseKey);
	
	</script>
@endsection