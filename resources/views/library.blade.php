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


	});

	var app = new Vue({
		el: '#app',
		data: {
			message: 'Hello Vue!',
			page: 1,
			sounds : []

		},
		created: function() {
			vm = this;
			this.$http.get('api/library').then((response) => {
				vm.sounds = JSON.parse(response.body);
			});
		}
	})
</script>

@endsection