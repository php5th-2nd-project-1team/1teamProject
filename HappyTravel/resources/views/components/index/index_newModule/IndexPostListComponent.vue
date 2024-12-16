<template>
	<div class="postList-container">
		<div class="postList-content">
			<div class="postList-inner">
				<h2>{{ title }}</h2>
				<p>{{ content }}</p>
			</div>
			<div class="postList-inner">
				<button :class="`${props.type}-prev`"><</button>
				<button :class="`${props.type}-next`">></button>
			</div>
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

</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation } from 'swiper/modules';
import { defineProps, ref } from 'vue';

import 'swiper/css';
import 'swiper/css/bundle';

import PostCardComponent from '../../post/component/PostCardComponent.vue';

const props = defineProps({
	type : String
	,cardData : Array
});

const modules = [Navigation];

const title = ref(props.type === 'view' ? '자주보는 포스트' : '인기있는 포스트');
const content = ref(props.type === 'view' ? '#조회수가 높은 포스트는?' : '#좋아요가 높은 포스트는?');
</script>
<style scoped>
	.postList-container{
		display: flex;
		flex-direction: column;
		gap : 1rem;
		align-items: center;

		width: 100%;
		height: 100%;
	}

	.postList-content{
		width: 100%;
		height: 3rem;
		display: flex;
		padding : 0 2rem;
		align-items: center;
		justify-content: space-between;
		gap : 1rem;
	}

	.postList-inner{
		display: flex;
		align-items: center;
		gap : 16px;
	}

	.postList-inner button{
		width: 2.5rem;
		height: 2.5rem;
		background-color: white;
		color : black;

		border : 1px solid black;
		border-radius: 100%;
	}

	.postList-inner button:hover{
		background-color: black;
		color : white;

		transition: all 0.1s;
	}

	.swiper{
		width: 100%;
	}
</style>