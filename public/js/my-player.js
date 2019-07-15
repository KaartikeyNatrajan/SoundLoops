Vue.component('my-player', {

	template: '#player',

	props: ['soundInfo'],

	data: function () {
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
				var maxTime = 0;
				var loopTime = 0;
				for (var i = 0; i < dataToPlay.drums.length; i++) {
					loopTime = Math.max(loopTime, dataToPlay.drums[i].endTime);
					this.tracks.push(dataToPlay.drums[i].track);
					if (loopTime > maxTime) {
						maxTime = loopTime;
					}
				}
				for (var i = 0; i < dataToPlay.bass.length; i++) {
					loopTime = Math.max(loopTime, dataToPlay.bass[i].endTime);
					this.tracks.push(dataToPlay.bass[i].track);
					if (loopTime > maxTime) {
						maxTime = loopTime;
					}
				}
				for (var i = 0; i < dataToPlay.drums.length; i++) {
					var t1 = setTimeout(play, dataToPlay.drums[i].startTime * 1000, dataToPlay.drums[i].track);
					var t2 = setTimeout(pauseit, dataToPlay.drums[i].endTime * 1000, dataToPlay.drums[i].track);
					this.timeouts.push(t1);
				}
				for (var i = 0; i < dataToPlay.bass.length; i++) {
					var t1 = setTimeout(play, dataToPlay.bass[i].startTime * 1000, dataToPlay.bass[i].track);
					var t2 = setTimeout(pauseit, dataToPlay.bass[i].endTime * 1000, dataToPlay.bass[i].track);
					this.timeouts.push(t1);
				}

				setTimeout(function () {
					vm.playing = false;
				}, maxTime * 1000);
			} else if (vm.playing == true) {
				vm.playing = false;
				for (var i = 0; i < this.timeouts.length; i++) {
					clearTimeout(this.timeouts[i]);
				}

				for (var i = 0; i < this.tracks.length; i++) {
					pauseit(this.tracks[i]);
				}
			}
		},
		toggleLike: function () {
			var id = this.soundInfo.soundId;
			vm = this;
			this.$http.put('api/library/' + id, {
				'_token': Laravel.csrfToken
			})
			.then((response) => {
				if (vm.hasLiked) {
					vm.upVotes -= 1;
				} else {
					vm.upVotes += 1;
				}
				vm.hasLiked = !vm.hasLiked;
			});
		}
	}
});
