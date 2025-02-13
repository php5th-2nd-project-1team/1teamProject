<template>
	<LoadingComponent v-if="LoadingFlg" />
	<div v-else>
	  <div class="community-notice-detail-container">
				<h1>문의사항 상세</h1> 
				<br><br>
		<div class="container">
			<div class="community-notice-detail-header">
				<div class="community-notice-detail-header-left-tag">
					<span>{{ inquiryDetail.inquiry_secret === 0 ? '일반' : '비밀글' }}</span>
				</div>
				<div class="community-notice-detail-header-right">
					<div class=community-notice-detail-header-right-top>
						<span>{{ inquiryDetail.inquiry_title }}</span>
					</div>
					<div class="community-notice-detail-header-right-bottom">
						<span>{{ inquiryDetail.users?.nickname }}</span>
						<span>{{ inquiryDetail.created_at }}</span>
					</div>
				</div>
			</div>
		
			<div class="container">
				<div class="content">
					<p v-if="inquiryDetail.inquiry_secret === 1 && 
						(isAuth === false || userInfo.user_id !== inquiryDetail.users.user_id)"
						style="text-align: center;">
						비밀글입니다.</p>
					<p v-else v-html="inquiryDetail.inquiry_content"></p>
				</div>               
			</div>
			<hr>
			<div class="container" v-if="inquiryDetail.inquiry_response !== null">
				<h1>문의사항 답변</h1>
				<div class="content">
					<p v-if="inquiryDetail.inquiry_secret === 1 && 
						(isAuth === false || userInfo.user_id !== inquiryDetail.users.user_id)"
						style="text-align: center;">
						비밀글입니다.</p>
					<p v-else v-html="inquiryDetail.inquiry_response"></p>
				</div>               
			</div>
			<div class="list_btn">
				<router-link to="/inquiries"><button class="btn btn-bg-blue btn-header">목록</button></router-link>
				<router-link to="#" ><button v-if="inquiryDetail.users.user_id === userInfo.user_id 
				&& inquiryDetail.inquiry_response === null
				&& inquiryDetail.inquiry_response === null"
				class="btn btn-bg-red btn-header" @click="deleteInquiry">삭제</button></router-link>
			</div>
		</div>
	  </div>   
	</div>
</template>

<script setup>
import LoadingComponent from '../utilities/LoadingComponent.vue';
import { useStore } from 'vuex';
import { computed, onBeforeMount} from 'vue';
import { useRoute } from 'vue-router';

	const store = useStore();
	const route = useRoute();

	const inquiryDetail = computed(() => store.state.inquiry.inquiryDetail);

	const LoadingFlg = computed(() => store.state.inquiry.isLoading);

	const isAuth = computed(() => store.state.auth.authFlg);
	const userInfo = computed(() => store.state.auth.userInfo);
	
	onBeforeMount(() => {
		store.dispatch('inquiry/getInquiryDetail', route.params.id);
	});

	const deleteInquiry = () => {
		if(confirm('삭제하시겠습니까?')){
			store.dispatch('inquiry/deleteInquiry', route.params.id);
		}
	}
</script>

<style scoped>

	.community-notice-detail-container {
		margin: auto;
		padding:0 300px;
	}

	.community-notice-detail-header {
		display: flex;
		height:150px;       
		border: 1px solid #BDBDBD;
	}
	/* 새로작성한 구간 */
  
	.community-notice-detail-header-left-tag {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 180px;
		background-color: #BDBDBD;
		color:#fff;
		font-size:1.8rem;
	}
	.community-notice-detail-header-left-tag-important {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 180px;
		background-color: #2986FF;
		color:#fff;
		font-size:1.8rem;
	}
	.community-notice-detail-header-right { 
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		flex: 1;
	}
	.community-notice-detail-header-right-top {
		display:flex;
		justify-content: center;
		height: 100%;
		align-items: center;
		font-size: 2rem;
	}
	
	.community-notice-detail-header-right-bottom {
		display: flex;
		justify-content: flex-end;
		width:100%;
		padding:10px;
		margin-right: 30px;
		gap: 100px;
		font-size:1rem;
		border-top: 1px solid #BDBDBD;
		color:#000;
	}

	/* 컨텐츠  */
	.container {
	display: flex;
	flex-direction: column; /* 세로로 배치 */
	gap: 20px; /* 콘텐츠와 이미지 영역 사이의 간격 */
	}

	.content {
	
	padding: 30px;
	margin-top: 100px;
	}

	.image {    
	display: flex; /* 이미지를 중앙에 정렬 */
	padding: 30px;
	align-items: center;
	justify-content: center;
	}
	.image img {
	width: 70%;   /* 이미지 너비를 div에 맞게 100% */
	object-fit: cover; /* 이미지가 div 크기에 맞게 비율 유지하며 잘라냄 */
	}

	/* 이미지가 없을 때 .image를 숨기기 */
	.image:empty {
	display: none; /* 이미지가 없으면 숨김 */
	}

	.list_btn {
		text-align: center;
		margin-top:20px;
	}
	.list_btn >.btn-header {
		font-size: 2rem;
		width:200px;
		height:50px;
		
	} 
</style>



