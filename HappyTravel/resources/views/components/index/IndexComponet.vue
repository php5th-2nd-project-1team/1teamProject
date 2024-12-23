<template>
	<div class="index-container">
		<IndexPostComponent :cardData="store.state.post.postIndexList"/>
		<IndexCommentBoxComponent/>
		<IndexMediaboxComponent/>
		<IndexPostListComponent :type="'view'" :cardData="store.state.post.viewList"/>
		<IndexPostListComponent :type="'like'" :cardData="store.state.post.likeList"/>
	</div>
	<div @click="onClickTopBtn" :class="isActiveTopBtn"></div>
</template>

<script setup>

import { ref, onBeforeMount, onBeforeUnmount, reactive } from 'vue';
import IndexCommentBoxComponent from './index_module/IndexCommentBoxComponent.vue';
import IndexMediaboxComponent from './index_module/IndexMediaboxComponent.vue';
import IndexPostListComponent from './index_newModule/IndexPostListComponent.vue';
import IndexPostComponent from './index_newModule/IndexPostComponent.vue';
import { useStore } from 'vuex';

const store = useStore();

const isActiveTopBtn = ref('index-btn-top');
const canClickBtn = ref('false');

const onScroll = () =>{
	const docHeight = document.documentElement.scrollHeight; // 문서 기준 Y축 총 길이
	const winHeight = window.innerHeight;											// window Y축 총 길이
	const nowHeight = window.scrollY;												// 현재 Y축
	const viewHeight = docHeight - winHeight;								// 끝까지 스크롤 했을 때 Y축의 길이

	if(nowHeight >= viewHeight * 0.3 ){
		isActiveTopBtn.value = 'index-btn-top index-btn-top-active';
		canClickBtn.value = true;
	} else {
		isActiveTopBtn.value = 'index-btn-top';
		canClickBtn.value = false;
	}
}

window.addEventListener('scroll', onScroll);
onBeforeMount(() => {
	store.dispatch('post/indexes');
});

onBeforeUnmount(()=>{
	store.commit('post/setInitialize');
})

const onClickTopBtn = () =>{
	if(canClickBtn.value){
		window.scrollTo(0, 0);
	}
}
</script>

<style scoped>
	@import url('../../../css/index.css');
	/* 전체 컨테이너 */
	.index-container{
		display: flex;
		flex-direction: column;
		align-items: center;

		gap:40px;

		padding: 0 200px;
	}

	/* top button */
	.index-btn-top{
		position: fixed;

		width: 100px;
		height: 100px;

		/* background-color: rgb(41, 134, 255); */
		background-image: url('/developImg/goTop.png');
		background-position: center;
		background-size: cover;
		background-repeat: no-repeat;

		opacity: 0;

		bottom: 10%;
		right: 10%;

		z-index: 1000;

		transition: all 0.5s;
	}

	.index-btn-top-active{
		opacity: 1;

		transition: all 0.5s;
	}

	/* 반응형 : 1439px */
	@media (max-width : 1439px){
		.index-container{
			padding: 0 100px;
		}
	}

	/* 반응형 : 1023px */
	@media (max-width : 1023px){
		.index-container{
			padding: 0 50px;
		}
	}

	/* 반응형 : 599px 이하 */
	@media (max-width : 599px){

	}
</style>