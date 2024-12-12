<template>
	<div class="index-container">
		<IndexEventboxComponent/>
		<IndexCommentBoxComponent/>
		<IndexMediaboxComponent/>
		<IndexPostboxComponent/>
		<IndexStoreboxComponent/>
		<IndexCommunityboxComponent/>
	</div>
</template>

<script setup>

import IndexCommentBoxComponent from './index_module/IndexCommentBoxComponent.vue';
import IndexCommunityboxComponent from './index_module/IndexCommunityboxComponent.vue';
import IndexEventboxComponent from './index_module/IndexEventboxComponent.vue';
import IndexMediaboxComponent from './index_module/IndexMediaboxComponent.vue';
import IndexPostboxComponent from './index_module/IndexPostboxComponent.vue';
import IndexStoreboxComponent from './index_module/IndexStoreboxComponent.vue';

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