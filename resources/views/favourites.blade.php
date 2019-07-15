@extends('layouts.master', ['title' => 'favourited sounds'])

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

<script type="text/javascript" src="{{ asset('js/my-player.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
			message: 'Favourites',
			sounds : []
		},
		created: function() {
			vm = this;
			this.$http.get('/api/favourites').then((response) => {
				vm.sounds = response.body.data;
			});
		}
	});
</script>

@endsection