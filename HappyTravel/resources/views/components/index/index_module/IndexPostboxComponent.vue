<template>
	<div class="index-postbox">
		<div class="index-postbox-title">
			<h3>미리보는 여행지</h3>
			<p>#귀여운 반려동물과 즐거운 여행을</p>
		</div>
		<div class="index-category">
			<!-- TODO 반응형으로 공간 줄어들 시 탭 수정 -->
			 <!-- 숙소, 관광지, 식음료, 병원 출력 -->
			<div class="index-category-category" v-for="(item, key) in categoryTheme" :key="key" @click="changeCategoryTheme(item.category_theme_num)">
				<p :class="{ 'selected': selectTheme === item.category_theme_num }" >{{ item.category_theme_name }}</p>
			</div>
		</div>
		<div class="index-cardzone">
			<div class="index-card" v-for="(item, key) in $store.state.post.indexPost" :key="item">
				<div @click="redirectDetail(item.category_theme_num, item.post_id)">
					<div class="index-card-img">
						<img :src="item.post_img" onerror="src='/developImg/no_img.jpg'"></div>
					<div class="index-card-hoverShowing">
						<div class="index-card-content">
							<p class="index-card-content-title">{{ item.post_title }}</p>
							<p class="index-card-content-local-name">{{ item.post_local_name}}</p>
						</div>
						<div class="index-card-btnArea">
							<!-- <button></button> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>
import { useStore } from 'vuex';
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import router from '../../../../js/router';
const store = useStore();
const route = useRoute();
const categoryTheme = [
	{category_theme_name: "숙소", category_theme_num: "01"}
	,{category_theme_name: "식음료", category_theme_num: "02"}
	,{category_theme_name: "관광지", category_theme_num: "03"}
	,{category_theme_name: "병원", category_theme_num: "04"}
];

onMounted(() => {
	store.dispatch('post/indexPost', '01');
});

// 선택된 테마 01로 고정
const selectTheme = ref('01');

const changeCategoryTheme = (CategoryThemeNum) => {
	// 카테고리테마 바꿀때마다 값 변경
	selectTheme.value = CategoryThemeNum;
	// post/indexPost 실행 / 파라미터로 CategoryThemeNum를 보내줌
	store.dispatch('post/indexPost', CategoryThemeNum);
};
// category_theme_num 이랑 post_id를 파라미터로 받아야함
const redirectDetail = (category_theme_num, post_id) => {
	// indexPost 는 배열이라 num 이랑 id 에 접근할수 없었음 => router.push()에서 indexPost 배열을 참조해서 undefined 발생
	// router.push(`/posts/${store.state.post.indexPost.category_theme_num}/${store.state.post.indexPost.post_id}`);
	router.push(`/posts/${category_theme_num}/${post_id}`);
};

</script>
<style scoped>
	.index-card-content-title {
		font-size: 25px;
	}
	.index-card-content-local-name {
		font-size: 15px;
		margin-bottom: 40px;
	}
	.selected {
		font-size: 1.3rem;
		color: #000;
	}
</style>