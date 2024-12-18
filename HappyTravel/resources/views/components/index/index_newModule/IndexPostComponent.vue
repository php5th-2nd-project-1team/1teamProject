<template>
	<div class="indexPost-container">
		<div class="indexPost-controller">
			<h4 class="indexPost-controller-title">최신 포스트 모음</h4>
			<Swiper
			:modules="modules"
			:slides-per-view="1"
			:space-between="0"
			:autoplay="{ delay: 2500, disableOnInteraction: false, }"
			:navigation="{ nextEl:`.indexPost-btn-next`, prevEl:`.indexPost-btn-prev`}"
			:allow-touch-move="false"
			:pagination="{ el: '.swiper-pagination', clickable: true }"
			@slideChange="syncSlides"
			>
				<SwiperSlide v-for="value in postList" :key="value">
					<h1>{{ value.post_title }}</h1>
					<br>
					<h3>{{ value.post_local_name }}</h3>
				</SwiperSlide>
			</Swiper>
			<div class="index-btn-area">
				<button class="indexPost-btn-next"><</button>
				<div class="swiper-pagination" style="position: static; width: 50%;"></div> 
				<button class="indexPost-btn-prev">></button>
			</div>
		</div>
		<div class="indexPost-view">
			<Swiper
			:modules="modules"
			:slides-per-view="1"
			:space-between="0"
			:autoplay="{ delay: 2500, disableOnInteraction: false, }"
			:navigation="{ nextEl:`.indexPost-btn-next`, prevEl:`.indexPost-btn-prev`}"
			:allow-touch-move="false"
			style="height: 100%; border-radius: 50px;"
			:pagination="{ el: '.swiper-pagination', clickable: true }"
			@slideChange="syncSlides"
			>
				<SwiperSlide v-for="value in postList" :key="value"><div class="indexPost-view-img" :style="{backgroundImage: 'url('+value.post_img+')'}"></div></SwiperSlide>
			</Swiper>
		</div>
	</div>
</template>
<script setup>
	import { Swiper, SwiperSlide } from 'swiper/vue';
	import { Navigation, Pagination, Autoplay } from 'swiper/modules'
	import 'swiper/css/bundle';
	import { useStore } from 'vuex';
	import { ref, computed } from 'vue';

	const store = useStore();
	const modules = [Navigation, Pagination, Autoplay];

	const postList = computed(()=>store.state.post.postIndexList);

	// Swiper 인스턴스 참조
	const swiperRef1 = ref(null);
	const swiperRef2 = ref(null);

	// 슬라이드 동기화 함수
	const syncSlides = () => {
		if (swiperRef1.value && swiperRef2.value) {
			const activeIndex = swiperRef1.value.swiper.activeIndex;
			swiperRef2.value.swiper.slideTo(activeIndex);
		}
	};
</script>
<style scoped>
	.indexPost-container{
		width: 80%;
		height: 500px;
		background: linear-gradient(#D2EEFF, #92D4FF);
		border-radius: 50px;
		display: flex;
		overflow: hidden;
	}

	/* index controller 영역 */
	.indexPost-controller{
		width: 40%;
		height: 100%;

		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: flex-start;

		padding: 1rem;
		gap:1rem;
	}

	.indexPost-controller-title{
		background-color: black;
		color:white;
		padding : 0.5rem 1rem;
		
		border-radius: 50px;
		border-bottom-left-radius: 0px;
	}

	.index-btn-area{
		width: 100%;
		display: flex;
		justify-content: space-between;
		gap: 1rem;
	}

	.index-btn-area button{
		width: 2rem;
		height: 2rem;
		
		border-radius: 100%;
		background-color: white;
	}

	/* index view 영역 */
	.indexPost-view{
		width: 60%;
		height: 100%;

		display: flex;
		justify-content: center;
		align-items: center;

		border-radius: 50px;

		padding : 2rem;
	}

	.indexPost-view-img{
		width: 100%;
		height: 100%;

		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	/* swier 영역 */
	.swiper-horizontal{
		width: 100% !important;
	}
	.swiper-slide {
    	max-width: 100%;  /* 슬라이드의 최대 너비를 부모에 맞춤 */
    	flex-shrink: 0;   /* 슬라이드가 축소되지 않도록 설정 */
		box-sizing: border-box;
	}

	:deep(.swiper-pagination-bullet) {
		width: 24px; /* 불릿 크기 설정 */
		height: 24px; /* 불릿 크기 설정 */
		background: rgba(0, 0, 0, 0.5); /* 기본 색상 */
		opacity: 1; /* 불릿의 불투명도 */
	}

	/* 페이지네이션 불릿 활성화 시 스타일 */
	:deep(.swiper-pagination-bullet-active) {
		background: #007aff; /* 활성화 시 색상 (예: 파란색) */
	}
</style>