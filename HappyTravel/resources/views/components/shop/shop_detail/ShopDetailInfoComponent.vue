<template>
	<LoadingComponent v-if="LoadingFlg" />
	<div v-else class="shopDetail-info-container">
		<div class="shopDetail-info-img" style="background-image: url('/developImg/about-three1.png');"></div>
		<div class="shopDetail-info">
			<div class="shopDetail-info-code">
				<p>상품 코드 {{ shopBoardDetail.class_id }}</p>
			</div>
			<div class="shopDetail-info-title">
				<h1>{{ shopBoardDetail.class_title }}</h1>
			</div>
			<div class="shopDetail-info-place">
				<p>장소 : {{ shopBoardDetail.location }}</p>
			</div>
			<div class="shopDetail-info-date">
				<p>날짜 : {{ shopBoardDetail.class_date }}</p>
			</div>
			<div class="shopDetail-info-price">
				<p>가격</p>
				<!-- toLocaleString : 숫자에 콤마 찍어줌. 100000 -> 100,000 -->
				<p>{{ shopBoardDetail.class_price }}원</p>
				<!-- <p>{{ formattedPrice }}원</p> -->
			</div>
			<div class="shopDetail-info-btn-container">
				<div class="shopDetail-info-btn">
					<button class="purchase-btn" @click="openModal()">구매하기</button>
					<button class="zzim-img" @click="onClkLikeBtn">
						<img :src="isClickedZzim" :class="likeBtnClassName" alt="" />
					</button>
				</div>
			</div>
		</div>
	</div>
	<ShopPaymentModalComponent v-if="isModalOpen" />
</template>
<script setup>
import { computed, onBeforeMount, onMounted, reactive, ref } from 'vue';
import ShopPaymentModalComponent from '../ShopPaymentModalComponent.vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import LoadingComponent from '../../utilities/LoadingComponent.vue';
import router from '../../../../js/router';

	const route = useRoute();    // 현재 라우트 정보 가져오기

	const store = useStore();

	const shopBoardDetail = computed(() => store.state.shop.shopBoardDetail);

	const isModalOpen = computed(()=> store.state.shop.isModalOpen);

	const LoadingFlg = computed(() => store.state.shop.LoadingFlg);

	onBeforeMount(() => {
		const shopId = route.params.id; // URL에서 id 파라미터 가져오기
		store.dispatch('shop/shopBoardDetail', shopId);
	});
	

	const openModal = () => {
		const userInfo = store.state.auth.userInfo;

		if (!userInfo || Object.keys(userInfo).length === 0) {
			return alert('로그인 후 이용해주세요.');
		}

		store.commit('shop/setIsModalOpen', true);
	}

	const isClickedZzim = ref(false);

	// const formattedPrice = computed(() => {
  	// 	const price = shopBoardDetail.value?.class_price ?? 0; // 값이 없으면 0으로 처리
  	// 	return price.toLocaleString('ko-KR');
	// });

	// 좋아요 찜 버튼
	const isClked = computed(() => store.state.shop.isClkedLike);
	const likeBtnClassName = computed(() => (isClked.value ? 'clk' : 'noClk'));

	onMounted(()=>{
		likeBtnClassName.value = isClked.value ? 'clk' : 'noClk';
	})
	const onClkLikeBtn = () => {
		if(!store.state.auth.authFlg) {
			alert('로그인 후 이용가능합니다.');
			router.push('/login');
			return;
		}
		store.commit('shop/setIsLikeLoading', true);
		store.dispatch('shop/classLike', route.params.id).catch(error => {
        console.error("Error in classLike action:", error);
    	});
		likeBtnClassName.value = isClked.value ? 'clk' : 'noClk';
	};

</script>
<style scoped>
	.shopDetail-info-container{
		display: grid;
		grid-template-columns: repeat(2, 1fr);

		width: 100%;
		min-height: 300px;
	}
	.shopDetail-info-img{
		width: 100%;
		height: 100%;

		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}
	.shopDetail-info{
		width: 100%;
		display: flex;
		flex-direction: column;
		gap : 1rem;
		padding: 0 1rem;
	}
	.shopDetail-info-code{
		display: flex;
		justify-content: flex-end;
		color: gray;
	}

	.shopDetail-info-price{
		display: flex;
		flex-direction: column;
		gap : 0.5rem;
	}
	.shopDetail-info-price :nth-child(1){
		font-size: 1.5rem;
	}
	.shopDetail-info-price :nth-child(2){
		font-size: 2rem;
	}
	.shopDetail-info-btn{
		display: flex;
		justify-content: center;

		gap : 1rem;

		width: 100%;
	}
	.purchase-btn{
		width: 60%;
		height: 50px;
		background-color: #2986FF;
		border: 3px solid #2986FF;
		border-radius: 500px;
		cursor: pointer;

		color : white;
		font-size: 1.5rem;
		cursor: pointer;
	}

	.purchase-btn:hover{
		background-color: white;

		color : black;

		transition : all 0.1s;
	}

	.zzim-img{
		width: 50px;
		height: 50px;

		display: flex;

		justify-content: center;
		align-items: center;

		cursor: pointer;

		background-color: transparent;

		border: none;
	}

	.zzim-img img{
		width: 100%;
		height: 100%;
	}
	.noClk{
	/* background-color: magenta; */
	background-image: url('/developImg/like_no.png');
	}

	.clk{
		/* background-color: #2986FF; */
		background-image: url('/developImg/like_yes.png');
		color: red;
	}
</style>