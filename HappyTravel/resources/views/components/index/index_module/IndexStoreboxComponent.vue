<template>
<div class="index-postbox">
	<div class="index-postbox-title">
			<h3>개 끝내주는 상품</h3>
			<p>#원하시는 상품을 찾아보세요</p>
		</div>
		<div class="index-category">
			<!-- <div class="index-category-category">
				<p>굿즈</p>
				<p>클래스</p>
				<p>패키지</p>
			</div> -->
			<!-- <div class="index-controller">
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
			</div> -->
		</div>
		<div class="index-cardzone">
			<div class="index-shop-card" v-for="(item, key) in $store.state.shop.indexShop" :key="key">
				<div class="index-shop-card-img">
					<img :src="item.class_title_img" @click="redirectDetail(item.class_id)" onerror="src='/developImg/no_img.jpg'">
					<!-- <div class="index-card-img" :src="item.class_title_img"></div> -->
					 <div class="badges">
						 <p class="badges-sale">sale</p>
						 <p class="badges-new">new</p>
					 </div>
				</div>
				<p class="index-card-product-name">{{ item.class_title }}</p>
				<p class="abc" data-descr="100,000원">{{ Number(item.class_price).toLocaleString('ko-KR') }}원</p>
				<div class="index-card-btnArea">
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';
import router from '../../../../js/router';
const store = useStore();
onMounted(() => {
	store.dispatch('shop/indexShop');
});

// shop 상세페이지로 이동
const redirectDetail = (class_id) => {
	router.push(`/shops/${class_id}`);
};

// import { Swiper, SwiperSlide } from 'swiper/vue';
// import { Navigation } from 'swiper/modules';
// import { defineProps } from 'vue';
// import 'swiper/css';
// import 'swiper/css/bundle';

// import PostCardComponent from '../../post/component/PostCardComponent.vue';

// const props = defineProps({
// 	type : String
// 	,cardData : Array
// });

// const modules = [Navigation];


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
		position: relative;
		display: inline-block;
		border-radius: 30px;
		overflow: hidden;
		margin-bottom: 10px;

		opacity: 1;
		transition: .2s ease-in-out;
	}

	.index-shop-card-img:hover {
		opacity: .8;
	}

	.index-shop-card-img img {
		width: 100%;
		height: 400px;
	}

	.badges {
		position: absolute;
		top: 10px;
		right: 10px;
		display: flex;
		gap: 5px;
	}

	.badges-sale {
		background-color: red;
	}

	.badges-new {
		background-color: orange;
	}

	.index-shop-card-img p{
		color: white;
		/* background-color: orange; */

		border-radius: 100%;

		width: 3rem;
		height: 3rem;

		margin : 15px 5px;
		padding: 20px;

		display: flex;
		justify-content: center;
		align-items: center;

		line-height: 16px;
	}

</style>