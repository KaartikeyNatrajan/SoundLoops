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
			<div style="padding:10px">
				<button v-if="!recording" class="btn btn-lg" style="background-color:red" @click="toggle">Record</button>
				<button v-else class="btn btn-lg" style="background-color:yellow" @click="toggle">Stop</button>
			</div>
			<div v-if="completed" class="col-md-4 col-md-offset-4">
				<div class="input-group input-group-lg">
					<input type="text" v-model="trackTitle" class="form-control form-control-lg" placeholder="Enter track title" required>
					<span class="input-group-btn">
						<button class="btn btn-lg btn-success" @click="saveSound">Save</button>
					</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/play.js') }}"></script>
	<script type="text/javascript">
		var recorder = new Vue({
			el: '#record',
			data: {
				trackTitle: null,
				recording: false,
				jsonData : null,
				completed : false,
				instrument : 0,
				keymap : {
					'Q' : 4,
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
					if (this.recording) {
						startTimer();
					} else {
						this.jsonData = finishRecording();
						this.completed = true;
						document.body.removeEventListener("keydown", this.playKey);
						document.body.removeEventListener("keyup", this.pauseKey);
					}
				},

				saveSound: function() {
					vm = this;
					if (vm.trackTitle == null || vm.trackTitle == "") {
						alert("please enter a name for the track");
						return;
					}
					this.$http.post('/create',{
						'_token': Laravel.csrfToken,
						'jsonData': vm.jsonData,
						'title' : vm.trackTitle
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
					if (this.instrument > 0) {
						this.instrument -= 1;
					}
				},

				playKey: function(event) {
					var key = event.keyCode;
					var char = String.fromCharCode(key);
					if (this.alreadyPlaying.indexOf(char) < 0) {
						play(this.keymap[char] + ( 13 * this.instrument ) );
						this.alreadyPlaying.push(char);
						var currentKey = document.getElementById("note" + (this.keymap[char] - 3));
						currentKey.className += " keypress";
					}
				},

				pauseKey: function(event) {
					var key = event.keyCode;
					var char = String.fromCharCode(key);
					pauseit(this.keymap[char] + ( 13 * this.instrument ) );
					this.alreadyPlaying.splice(this.alreadyPlaying.indexOf(char),1);
					var currentKey = document.getElementById("note" + (this.keymap[char] - 3));
					$(currentKey).removeClass("keypress");
				}
			}
		});

		function noteClick(note) {
			noteId = note + 3;
			play(noteId);
		}
		document.body.addEventListener("keydown", recorder.playKey);
		document.body.addEventListener("keyup", recorder.pauseKey);
	</script>
@endsection