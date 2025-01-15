<template>
	<div class="shop-card-area">
		<div class="shop-card" v-for="i in 10" :key="i" @click="router.push('/shops/1')">
			<div class="shop-card-img" style="background-image: url('/developImg/about-three1.png');"></div>
			<h2 class="shop-card-title">카드 제목</h2>
			<div class="shop-card-info">
				<p>제주 스타벅스</p>
				<p>2021.10.10</p>
			</div>
			<h3 class="shop-card-price">1,500,000원</h3>
		</div>
	</div>
</template>
<script setup>
	import { useRouter } from 'vue-router';

	const router = useRouter();
</script>
<style scoped>
	.shop-card-area{
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
		grid-auto-rows: 300px;

		width: 100%;

		gap : 1rem;
	}
	.shop-card{
		width: 100%;
		height: 100%;

		display: flex;
		flex-direction: column;

		gap : 0.25rem;

		cursor: pointer;
	}
	.shop-card-img{
		width: 100%;
		padding-top: 70%;

		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}
	.shop-card-info{
		display: flex;
		justify-content: flex-start;
		align-items: flex-end;
		gap : 1rem;
	}
</style>