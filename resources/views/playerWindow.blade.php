<template id="player">
	<div class="container player-window">
		
		<p v-if="soundInfo.user != null">Posted by @{{ soundInfo.user.name }} on @{{ soundInfo.created_at }}</p>
		<div>
			<button class="play-button">
				<span class="glyphicon glyphicon-play-circle"></span>
			</button>
			<progress value="1" max="100" style="display:inline">
			
		</div>
		<p>@{{ soundInfo.data }}</p>

		<div class="like-bar">
			<button class="likeButton" @click="toggleLike">Like</button>
			<span>@{{ upVotes }}</span>
		</div>
	</div>
</template>