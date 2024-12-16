<template>
	<div class="card-container" @click="onClick(props.link), item.post_id" :key="item">
		<div class="card-img" :style="{backgroundImage: 'url('+props.img+')'}"></div>
		<div class="card-text">
			<div class="card-title">
				<h1 class="card-title-text">제목</h1>
			</div>
			<div class="card-info">
				<p class="card-info-writer">관리자</p>
				<p class="card-info-created">2020-20-20</p>
			</div>
		</div>
	</div>
</template>
<script setup>
	import { defineProps } from 'vue';
	const props = defineProps({
		img : String
		,link : String
	});

	const onClick = (url) => {
		console.log(url);
	}
</script>
<style scoped>
	*{
		margin:0;
		padding: 0;
		box-sizing: border-box;
	}
	.card-container{
		width: 350px;
		height : 300px;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		padding : 10px;

		background-color: #bdbdbd;
		border-radius: 16px;

		cursor: pointer;
	}

	.card-img{
		padding-top: 75%;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;

		border-radius: 32px;
	}
	.card-text{
		display: flex;
		flex-direction: column;
		padding: 0 20px;

		gap : 10px
	}
	.card-info{
		display: flex;
		justify-content: space-between;
	}
</style>