<template>
	<div class="shop-card-area">
		<div class="shop-card" v-for="i in shopBoardList" :key="i" @click="router.push(`/shops/${i.class_id}`)">
			<!-- router.push(`/shops/${i.class_id}`) -->
			<div class="shop-card-img" 
				:style="{ backgroundImage: `url(${i.class_title_img})` }">
			</div>
			<h2 class="shop-card-title">{{ i.class_title }}</h2>
			<div class="shop-card-info">
				<p>{{ i.location }}</p>
				<p>{{ i.class_date }}</p>
			</div>
			<h3 class="shop-card-price">{{ i.class_price.toLocaleString('ko-KR') }}원</h3>
		</div>
	</div>
	<button v-if="!lastPageFlg" class="more-button" @click="$store.dispact('shop/shopBoardList', $store.state.shop.currentSave)">더 보기</button>
</template>
<script setup>
	import { computed } from 'vue';
	import { useRouter } from 'vue-router';
	import { useStore } from 'vuex';

	const router = useRouter();

	const store = useStore();

    const shopBoardList = computed(() => store.state.shop.shopBoardList);

	const lastPageFlg = computed(() => store.state.shop.lastPageFlg);

	console.log(lastPageFlg.value);
	
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
	.more-button {
		background-color: #2986FF; /* 핵심 컬러 */
		color: white; /* 텍스트 색상 */
		border: none; /* 테두리 제거 */
		padding: 12px 30px; /* 버튼 크기 조정 */
		font-size: 16px;
		font-weight: bold;
		border-radius: 25px; /* 둥근 모서리 */
		cursor: pointer;
		transition: background-color 0.3s ease, transform 0.2s ease;
	}
</style>