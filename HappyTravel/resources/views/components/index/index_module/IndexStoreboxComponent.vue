<template>
<div class="index-postbox">
	<div class="index-postbox-title">
			<h3>개 끝내주는 상품</h3>
			<p>#원하시는 상품을 찾아보세요</p>
		</div>
		<div class="index-category">
			<div class="index-category-category">
				<p>굿즈</p>
				<p>클래스</p>
				<p>패키지</p>
			</div>
			<div class="index-controller">
				<div class="postList-inner">
					<button :class="`${props.type}-prev`" style="cursor: pointer;"><</button>
					<button :class="`${props.type}-next`" style="cursor: pointer;">></button>
				</div>
				<swiper
					:slides-per-view="3"
					:space-between="50"
					:modules="modules"
					:navigation="{ nextEl:`.${props.type}-next`, prevEl:`.${props.type}-prev`}"
				>
					<swiper-slide v-for="value in props.cardData"><PostCardComponent :cardData="value"/></swiper-slide>
				</swiper>
			</div>
		</div>
		<div class="index-cardzone">
			<div class="index-shop-card" v-for="value in 3" :key="value">
				<div class="index-shop-card-img">
					<p class="index-shop-card-img-option">sale</p>
					<p class="index-shop-card-img-option">new</p>
				</div>
				<p class="index-card-product-name">상품이름</p>
				<p class="abc" data-descr="100,000원">200,000원</p>
				<div class="index-card-btnArea">
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation } from 'swiper/modules';
import { defineProps } from 'vue';

import 'swiper/css';
import 'swiper/css/bundle';

import PostCardComponent from '../../post/component/PostCardComponent.vue';

const props = defineProps({
	type : String
	,cardData : Array
});

const modules = [Navigation];

</script>
<style scoped>
	.abc {
		color: #2986FF;
		font-size: 20px;
	}
	/* 여행지 상품 */
	.abc[data-descr]::after{
		content: attr(data-descr);
		text-decoration: line-through;
		margin-left: 10px;
		color: #939393;
		font-size: 15px;
	}

	.index-card-product-name {
		font-size: 20px;
	}

	.index-shop-card{
		border-radius: 50px;
		width: 100%;
		height: 100%;

		display: flex;
		flex-direction: column;
		align-items: center;
		cursor: pointer;
	}

	.index-shop-card-img{
		display: flex;
		width: 100%;
		padding-bottom: 40%;
		border-radius: 50px;

		justify-content: flex-end;

		background-color: rgb(73, 63, 54);

		margin-bottom: 20px;
	}

	.index-shop-card-img p{
		color: white;
		background-color: orange;

		border-radius: 100%;

		width: 3rem;
		height: 3rem;

		margin : 15px 10px;
		padding: 20px;

		display: flex;
		justify-content: center;
		align-items: center;

		line-height: 16px;
	}

</style>