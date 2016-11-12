Vue.component('my-player', {
	
	template: '#player',
	
	props: ['soundInfo'],

	data:  
		function() {
		return {
			upVotes: this.soundInfo.upCount,
			hasLiked: this.soundInfo.hasLiked,
			playing: false,
			timeouts: [],
			tracks: []
		}
	},

	methods: {
		playTrack: function () {
			vm = this;
			var dataToPlay = JSON.parse(vm.soundInfo.data);

			if (vm.playing == false) {
				this.playing = true;
				// console.log(dataToPlay.bass.length);
				var loopTime = 0;
				for (var i = 0; i < dataToPlay.drums.length; i++) {
					loopTime = Math.max(loopTime, dataToPlay.drums[i].endTime);
					this.tracks.push(dataToPlay.drums[i].track);
				}
				for (var i = 0; i < dataToPlay.bass.length; i++) {
					loopTime = Math.max(loopTime, dataToPlay.bass[i].endTime);
					this.tracks.push(dataToPlay.bass[i].track);
				}
				console.log(loopTime);
				for (var i = 0; i < dataToPlay.drums.length; i++) {
					var t1 = setTimeout(play, dataToPlay.drums[i].startTime*1000, dataToPlay.drums[i].track);
					var t2 = setTimeout(pauseit, dataToPlay.drums[i].endTime*1000, dataToPlay.drums[i].track);
					this.timeouts.push(t1);
				}
				for (var i = 0; i < dataToPlay.bass.length; i++) {
					var t1 = setTimeout(play, dataToPlay.bass[i].startTime*1000, dataToPlay.bass[i].track);
					var t2 = setTimeout(pauseit, dataToPlay.bass[i].endTime*1000, dataToPlay.bass[i].track);
					this.timeouts.push(t1);
				}

				console.log(this.timeouts);
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
			else if (vm.playing == true) {
				vm.playing = false;
				console.log("The playing true case is called");
				console.log(this.timeouts.length);
				for (var i = 0; i < this.timeouts.length; i++) {
					console.log(this.timeouts[i]);
					clearTimeout(this.timeouts[i]);
				}

				for (var i = 0; i < this.tracks.length; i++) {
					pauseit(this.tracks[i]);
				}
			}	
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
