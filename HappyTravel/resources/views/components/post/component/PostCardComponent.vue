<template>
	<div class="post-content-card" @click="redirectDetail(props.cardData.post_id)">
		<img class="post-content-card-img" :src="props.cardData.post_img" alt="">
		<h3>{{ props.cardData.post_title }}</h3>
		<p>{{ props.cardData.post_local_name }}</p>
		<div class="post-content-card-info">
			<p>조회수 : {{ props.cardData.post_view }}</p>
			<p>좋아요 : {{ props.cardData.post_likes_count }}</p>
		</div>
	</div>
</template>
<script setup>
	import { defineProps } from 'vue';
	import { useRouter } from 'vue-router';

	const router = useRouter();

	const props = defineProps({
		cardData : Object
	});

	const redirectDetail = (post_id) => {
		router.push('/posts/'+post_id);
	}
</script>
<style scoped>
	.post-content-card{
		display: flex;
		flex-direction: column;
		align-items: center;
		gap : 0.1rem;
		cursor: pointer;
	}

	.post-content-card-img {
		width: 100%;
		height: 300px;
		border-radius: 30px;
		opacity: 1;
		transition: .2s ease-in-out;
		/* -webkit-transition: .2s ease-in-out; */
	}

	.post-content-card-img:hover {
		opacity: .8;
	}

	.post-content-card-info{
		width: 80%;
		display: flex;
		justify-content: center;
		gap : 1rem;
	}
</style>