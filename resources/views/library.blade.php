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

<script type="text/javascript">

	Vue.component('my-player', {
		
		template: '#player',
		
		props: ['soundInfo'],

		data: function() {
			return {
				upVotes: this.soundInfo.upCount
			}
		},

		methods: {
			toggleLike: function()
			{
				var id = 1;
				vm = this;
				this.$http.put('api/library/' + id, {'_token': Laravel.csrfToken })
				.then((response) => {
					vm.upVotes += 1;

				});
			}
		}

	});

	var app = new Vue({
		el: '#app',
		data: {
			message: 'Hello Vue!',
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