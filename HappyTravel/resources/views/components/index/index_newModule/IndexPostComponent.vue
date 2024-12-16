<template>
	<div class="index-eventbox">
			<Swiper
			:modules="modules"
			slidesPerView="1"
			spaceBetween="0"
			:navigation="{ nextEl:'.index-event-nextbtn', prevEl:'.index-event-prevbtn'  }">
				<h1>최신 포스트 모음</h1>
				<SwiperSlide>1</SwiperSlide>
				<SwiperSlide>2</SwiperSlide>
				<SwiperSlide>3</SwiperSlide>
				<SwiperSlide>4</SwiperSlide>
				<SwiperSlide>5</SwiperSlide>
				<SwiperSlide>6</SwiperSlide>
				<button>asdfasdfasdfasddf</button>
				<div>
					<button class=".index-event-nextbtn"><</button>
					<button class=".index-event-prevbtn">></button>
				</div>
			</Swiper>
		</div>
</template>
<script setup>
	import { defineProps } from 'vue';
	import { Swiper, SwiperSlide } from 'swiper/vue';
	import { Navigation } from 'swiper/modules';

	import 'swiper/css';
	import 'swiper/css/bundle';
	import 'swiper/swiper-bundle.css';

	const props = defineProps({
		cardData : Object
	})

const modules = [Navigation];
</script>
<style scoped>

	.index-eventbox{
		width: 80%;
		height: 500px;  
		background: linear-gradient(#D2EEFF, #92D4FF);
		
		display: grid;
		grid-template-columns: 1fr 2fr;
		
		border-radius: 80px;
		
		padding: 0 2rem;
	}

	.swiper{
		display: flex;
		width: 100%;
		height: 100%;
	}

	.index-event-controller{
		display: flex;
		flex-direction: column;
		justify-content: center;
		
		gap: 10px;
		
		padding-left: 16px;
	}

	.swiper{
		width: 400px;
	}

	.swiper div{
		width: 100%;
	}
	
	.index-event-comment{
		background-color: black;
		color: white;
		width: 250px;
		height: 32px;
		display: flex;
		justify-content: center;
		align-items: center;

		border-radius: 200px;
		border-bottom-left-radius: 0%;
	}

	.index-event-buttonArea{
		display: flex;
		justify-content: space-between;
		align-items: center;
		width: 200px;
	}

	.index-event-nextbtn, .index-event-prevbtn{
		background-color: white;
		border: 0.05px solid black;
		border-radius: 100%;
		font-size: 0.6rem;
		padding: 5px;
	}

	.index-event-btn{
		background: #ECECEC;
		width: 1.2rem;
		height: 1.2rem;
		border: none;
		border-radius: 100%;
	}

	.index-event-activebtn{
		background-color: #2986FF;
	}

	.index-event-viewer{
		width: 100%;
		height: 100%;

		padding : 80px;
	}

	.index-event-img{
		background-color: white;
		width: 100%;
		height: 100%;

		/* border-radius: 50px; */

		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}

	/* 반응형 : 1023px */
	@media (max-width : 1023px){
		.index-eventbox{
			grid-template-columns: none;
			grid-template-rows: 1fr 1fr;
		}

		.index-event-viewer{
			padding: 20px;
		}
	}

	/* 반응형 : 599px 이하 */
	@media (max-width : 599px){
		.index-eventbox{
			width: 90%;
			padding: 0;
		}
		.index-event-comment{
			width: 200px;
		}
		.index-event-comment p{
			font-size: 0.7rem;
		}
		h1{
			font-size: 1.5rem;
		}
	}
</style>