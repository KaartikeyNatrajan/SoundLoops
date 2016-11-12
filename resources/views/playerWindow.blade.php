<template id="player">
	<div class="container player-window">
		
		<p v-if="soundInfo.user != null">Posted by @{{ soundInfo.user.name }} on @{{ soundInfo.created_at }}</p>
		<div>
			<button class="play-button" @click="playTrack">
				<span class="glyphicon glyphicon-play-circle"></span>
			</button>
			<progress value="1" max="100" style="display:inline">
			
		</div>
		<p>@{{ soundInfo.data }}</p>

		<div class="like-bar">
			<button class="likeButton" v-if="!hasLiked" @click="toggleLike">
				Like <span class="glyphicon glyphicon-thumbs-up" style="color:white"></span>
			</button>
			<button class="likeButton" v-else @click="toggleLike">UnLike <span class="glyphicon glyphicon-thumbs-down"></span></button>
			<span class="pull-right"><strong>@{{ upVotes }}</strong></span>
		</div>
	</div>
</template>