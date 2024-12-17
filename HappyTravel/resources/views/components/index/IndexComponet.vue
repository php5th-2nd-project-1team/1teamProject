<template>
	<div class="index-container">
		<IndexPostComponent :cardData="store.state.post.postIndexList"/>
		<IndexCommentBoxComponent/>
		<IndexMediaboxComponent/>
		<IndexPostListComponent :type="'view'" :cardData="store.state.post.viewList"/>
		<IndexPostListComponent :type="'like'" :cardData="store.state.post.likeList"/>
	</div>
</template>

<script setup>

import { onBeforeMount, onBeforeUnmount } from 'vue';
import IndexCommentBoxComponent from './index_module/IndexCommentBoxComponent.vue';
import IndexMediaboxComponent from './index_module/IndexMediaboxComponent.vue';
import IndexPostListComponent from './index_newModule/IndexPostListComponent.vue';
import IndexPostComponent from './index_newModule/IndexPostComponent.vue';
import { useStore } from 'vuex';

const store = useStore();


onBeforeMount(() => {
	store.dispatch('post/indexes');
});

onBeforeUnmount(()=>{
	store.commit('post/setInitialize');
})

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