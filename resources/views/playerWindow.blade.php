<template id="player">
	<div class="container player-window">
		<p>Posted by @{{ soundInfo.user.name }} on @{{ soundInfo.created_at }}</p>
		<div>
			<button class="play-button">
				<i class="glyphicon glyphicon-play-circle"></i>
			</button>
			<progress value="1" max="100" style="display:inline">
			
		</div>
		<p>@{{ soundInfo.data }}</p>

		<div class="like-bar">
			
		</div>
	</div>
</template>