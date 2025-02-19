<template>
	<div class="index-postbox">
		<div class="index-postbox-title">
			<h3>커뮤니티 반려동물 자랑</h3>
			<p>#귀여운 댕댕이의 멋진 모습을 자랑해주세요</p>
			<!-- <div class="index-controller">
				<button><</button>
				<button>></button>
			</div> -->
		</div>
		<div class="index-cardzone">
			<div class="index-card" v-for="(item, key) in $store.state.boards.indexCommunity" :key="key">
				<div class="community-card-content" @click="redirectDetail(item.community_id)">
					<img class="community-card-img" :src="item.community_photo_url" onerror="src='/developImg/no_img.jpg'">
				</div>

			</div>
		</div>
	</div>
</template>
<script setup>
import { useStore } from 'vuex';
import { onMounted } from 'vue';
import router from '../../../../js/router';
const store = useStore();
onMounted(() => {
	store.dispatch('boards/indexCommunity');
});

const redirectDetail = (community_id) => {
	router.push(`/community/free/${community_id}`);
}

</script>
<style scoped>
	.community-card-content {
		width: 100%;
		height: 100%;
	}

	.community-card-img {
		width: 100%;
		height: 100%;
		border-radius: 50px;
		padding: 15px 0;
	}
</style>