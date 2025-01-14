<template>
	<div class="shop-calander">
		<div class="shop-calander-controller">
			<button><</button>
			<span>2025년 1월</span>
			<button>></button>
		</div>
		<div class="shop-calander-date">
			<button><</button>
			<Swiper
			:slides-per-view="15"
			:space-between="5">
				<SwiperSlide v-for="i in 31" :key="i">
					<div class="swiper-slide holiday" v-if="i%7 === 0">
						<p>{{ week(i) }}</p>
						<p>{{i}}</p>
					</div>
					<div class="swiper-slide weekend" v-else-if="i%7 === 6">
						<p>{{ week(i) }}</p>
						<p>{{i}}</p>
					</div>
					<div class="swiper-slide" v-else>
						<p>{{ week(i) }}</p>
						<p>{{i}}</p>
					</div>
				</SwiperSlide>
			</Swiper>
			<button>></button>
		</div>
	</div>
</template>
<script setup>
	import { Swiper, SwiperSlide } from 'swiper/vue';

	// 테스트용
	const week = function(num){
		const week = ['일', '월', '화', '수', '목', '금', '토'];
		return week[num%7];
	}
</script>
<style scoped>
	.shop-calander{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        padding : 1rem;

        width: 100%;

		gap:2rem;

		border: 1px solid #000;

		border-radius: 10px;

		background-color: rgb(200, 200, 200);
    }
	.shop-calander-controller{
		display: flex;
		justify-content: center;
		align-items: center;
		gap : 1rem;

		width: 100%;
	}
    .shop-calander-date{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap : 1rem;

		width: 100%;

		border: 1px solid rgb(0, 0, 0);
		border-radius: 10px;

		background-color: white;

		padding : 1rem;
    }
	.swiper-slide{
		cursor: pointer;

		display: flex;
		flex-direction: column;
		gap : 1rem;
	}

	.holiday{
		color: #f00;
	}
	.weekend{
		color: #00f;
	}
</style>