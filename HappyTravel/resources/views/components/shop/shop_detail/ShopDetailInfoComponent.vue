<template>
	<div class="shopDetail-info-container">
		<div class="shopDetail-info-img" style="background-image: url('/developImg/about-three1.png');"></div>
		<div class="shopDetail-info">
			<div class="shopDetail-info-code">
				<p>상품 코드 {{ shopDetailInfo.code }}</p>
			</div>
			<div class="shopDetail-info-title">
				<h1>{{ shopDetailInfo.name }}</h1>
			</div>
			<div class="shopDetail-info-place">
				<p>장소 : {{ shopDetailInfo.place }}</p>
			</div>
			<div class="shopDetail-info-date">
				<p>날짜 : {{ shopDetailInfo.date }}</p>
			</div>
			<div class="shopDetail-info-price">
				<p>가격</p>
				<!-- toLocaleString : 숫자에 콤마 찍어줌. 100000 -> 100,000 -->
				<p>{{ shopDetailInfo.price.toLocaleString('ko-KR') }}원</p>
			</div>
			<div class="shopDetail-info-btn">
				<button>구매하기</button>
			</div>
		</div>
	</div>
	<ShopPaymentModalComponent v-if="true"/>
</template>
<script setup>

import { reactive } from 'vue';
import ShopPaymentModalComponent from '../ShopPaymentModalComponent.vue';

	const shopDetailInfo = reactive({
		code: '12345678',
		name: '구릉이네 간식 만들기 맛있는 간식 만들자',
		price: 10000000,
		place: '비산 4동 주민센터',
		date: '2999년 13월 32일'
	});

</script>
<style scoped>
	.shopDetail-info-container{
		display: grid;
		grid-template-columns: repeat(2, 1fr);

		width: 100%;
		min-height: 300px;
	}
	.shopDetail-info-img{
		width: 100%;
		height: 100%;

		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}
	.shopDetail-info{
		width: 100%;
		display: flex;
		flex-direction: column;
		gap : 1rem;
		padding: 0 1rem;
	}
	.shopDetail-info-code{
		display: flex;
		justify-content: flex-end;
		color: gray;
	}

	.shopDetail-info-price{
		display: flex;
		flex-direction: column;
		gap : 0.5rem;
	}
	.shopDetail-info-price :nth-child(1){
		font-size: 1.5rem;
	}
	.shopDetail-info-price :nth-child(2){
		font-size: 2rem;
	}
	.shopDetail-info-btn{
		display: flex;
		justify-content: center;
		width: 100%;
	}
	.shopDetail-info-btn button{
		width: 60%;
		height: 50px;
		background-color: #2986FF;
		border: 3px solid #2986FF;
		border-radius: 500px;
		cursor: pointer;

		color : white;
		font-size: 1.5rem;
		cursor: pointer;
	}

	.shopDetail-info-btn button:hover{
		background-color: white;

		color : black;

		transition : all 0.1s;
	}
</style>