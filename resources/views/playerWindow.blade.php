<template id="player">
	<div class="container player-window">
		<p v-if="soundInfo.user != null">
			Posted by @{{ soundInfo.user.name }} on @{{ soundInfo.created_at }}
		</p>
		<div style="position:relative">
			<button v-if="!playing" class="play-button" @click="playTrack">
				<span class="glyphicon glyphicon-play play-sound"></span>
			</button>
			<button v-else class="play-button" @click="playTrack">
				<span class="glyphicon glyphicon-pause play-sound"></span>
			</button>
			<span class="track-title">@{{ soundInfo.title }}</span>
			<!-- <progress value="1" max="100" style="display:inline"></progress> -->	
		</div>
		<div class="like-bar">
			<button class="likeButton" v-if="!hasLiked" @click="toggleLike">
				Like <span class="glyphicon glyphicon-thumbs-up" style="color:white"></span>
			</button>
			<button class="likeButton" v-else @click="toggleLike">
				UnLike <span class="glyphicon glyphicon-thumbs-down"></span>
			</button>
			<span class="pull-right like-count">
				<strong>@{{ upVotes }} Likes</strong>
			</span>
		</div>
	</div>
</template>