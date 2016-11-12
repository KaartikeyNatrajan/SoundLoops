@extends('layouts.master')

@section('content')
	
	<div class="container" id="app">
		<h1>@{{ message }}</h1>
		<div v-for="sound in sounds">
	    	<my-player :sound-info="sound"></my-player>
		</div>
	</div>

	@include('playerWindow')

@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('js/main2.js') }}"></script>
<script type="text/javascript">

	Vue.component('my-player', {
		
		template: '#player',
		
		props: ['soundInfo'],

		data: function() {
			return {
				upVotes: this.soundInfo.upCount,
				hasLiked: this.soundInfo.hasLiked,
				playing: false
			}
		},

		methods: {
			playTrack: function () {
				vm = this;
				var dataToPlay = JSON.parse(vm.soundInfo.data);
				var timeouts = new Array(/*dataToPlay.drums.length + dataToPlay.bass.length*/);
				var tracks = new Array();

				if (vm.playing == false) {
					this.playing = true;
					// console.log(dataToPlay.bass.length);
					var loopTime = 0;
					for (var i = 0; i < dataToPlay.drums.length; i++) {
						loopTime = Math.max(loopTime, dataToPlay.drums[i].endTime);
						tracks.push(dataToPlay.drums[i].track);
					}
					for (var i = 0; i < dataToPlay.bass.length; i++) {
						loopTime = Math.max(loopTime, dataToPlay.bass[i].endTime);
						tracks.push(dataToPlay.bass[i].track);
					}
					console.log(loopTime);
					for (var i = 0; i < dataToPlay.drums.length; i++) {
						var t1 = setTimeout(play, dataToPlay.drums[i].startTime*1000, dataToPlay.drums[i].track);
						var t2 = setTimeout(pauseit, dataToPlay.drums[i].endTime*1000, dataToPlay.drums[i].track);
						timeouts.push(t1, t2);
					}
					for (var i = 0; i < dataToPlay.bass.length; i++) {
						var t1 = setTimeout(play, dataToPlay.bass[i].startTime*1000, dataToPlay.bass[i].track);
						var t2 = setTimeout(pauseit, dataToPlay.bass[i].endTime*1000, dataToPlay.bass[i].track);
						timeouts.push(t1, t2);
					}
					// setInterval(function () {
					// 	console.log("setInterval is being called");
					// 	for (var i = 0; i < dataToPlay.drums.length; i++) {
					// 		setTimeout(play, dataToPlay.drums[i].startTime*1000, dataToPlay.drums[i].track);
					// 		setTimeout(pauseit, dataToPlay.drums[i].endTime*1000, dataToPlay.drums[i].track);
					// 	}
					// 	for (var i = 0; i < dataToPlay.bass.length; i++) {
					// 		setTimeout(play, dataToPlay.bass[i].startTime*1000, dataToPlay.bass[i].track);
					// 		setTimeout(pauseit, dataToPlay.bass[i].endTime*1000, dataToPlay.bass[i].track);
					// 	}
					// }, loopTime*1000);
				}
				// else if (vm.playing == true) {
				// 	vm.playing = false;
				// 	console.log("The playing true case is called");
				// 	for (var i = 0; i < timeouts.length; i++) {
				// 		clearTimeout(timeouts[i]);
				// 	}
				// 	// for (var i = 0; i < tracks.length; i++) {
				// 	// 	tracks[i]
				// 	// }
				// }	
			},
			toggleLike: function()
			{
				var id = 1;
				vm = this;
				this.$http.put('api/library/' + id, {'_token': Laravel.csrfToken })
				.then((response) => {
					if(vm.hasLiked)
					{
						vm.upVotes -= 1;
					}
					else
					{
						vm.upVotes += 1;
					}
					vm.hasLiked = !vm.hasLiked;

				});
			}
		}

	});

	var app = new Vue({
		el: '#app',
		data: {
			message: 'Community library',
			sounds : []
		},
		created: function() {
			vm = this;
			this.$http.get('api/library').then((response) => {
				console.log(response.body.data);
				vm.sounds = response.body.data.data;
			});
		}
	})
</script>




@endsection