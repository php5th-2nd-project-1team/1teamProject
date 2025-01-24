<template>
	<div class="paymodal-bg">
		<div class="paymodal-container" style="overflow: scroll;">
			<div class="paymodal-clientInfo">
				<ShopModalClientInfo />
				<ShopModalAnimalsInfo/>
			</div>
			<div class="paymodal-rules">
				<ShopModalRule/>
			</div>
			<div class="buttonArea">
				<button @click="handlePayment()">예약하기</button>
				<button @click="store.commit('shop/setIsModalOpen', false)">뒤로가기</button>
			</div>
		</div>
	</div>
</template>
<script setup>
	import { computed, onMounted, ref } from 'vue';
	import ShopModalAnimalsInfo from './shop_modal/ShopModalAnimalsInfo.vue';
	import ShopModalClientInfo from './shop_modal/ShopModalClientInfo.vue';
	import ShopModalRule from './shop_modal/ShopModalRule.vue';
	import { useStore } from 'vuex';
	import PortOne from '@portone/browser-sdk/v2';
	import { useRouter } from 'vue-router';
	
	const store = useStore();

	const router = useRouter();

	const paymentStatus = ref('IDLE');

	// const animal_type = computed(() => store.state.shop.animalInfos.animal_type);
	// const notes = computed(() => store.state.shop.animalInfos.notes);

	const paymentDetails = {
		purchase_price: store.state.shop.shopBoardDetail.class_price, // 결제 금액
		user_id: store.state.auth.userInfo.user_id, // store로 변경
		contact: store.state.auth.userInfo.phone_number, // 연락처
		reservations_name: store.state.auth.userInfo.name, // 예약자 이름
		animal_type: store.state.shop.animalInfos.animal_type, // 동물 종류
		notes: store.state.shop.animalInfos.notes, // 주의사항
		class_id: store.state.shop.shopBoardDetail.class_id, // 결제한 클래스 아이디
		reservations_number: store.state.shop.peopleCount
	};

	const handlePayment = async () => {
	try {
		// 1. 결제 요청
		const { merchant_uid, amount } = await store.dispatch('shop/requestPayment', paymentDetails);

		// 2. PortOne 결제 요청
		// const PortOne = PortOneModule.default;

		// const iamport = new PortOne({
		// 	impKey: '5735356664718760', // 본인의 impKey
		// });

		IMP.init("imp61168201"); // 예: 'imp00000000'

		IMP.request_pay({
			pg: 'kakaopay', // 테스트 PG사
			pay_method: 'card',
			merchant_uid, // 주문 ID
			name: store.state.shop.shopBoardDetail.class_title,
			amount, // 결제 금액
			buyer_name: store.state.auth.userInfo.name,
			buyer_tel: store.state.auth.userInfo.phone_number,
		}, async (rsp) => {
			if (rsp.success) {  // rsp.success로 변경
				// 3. 결제 승인 요청
				await store.dispatch('shop/confirmPayment', {imp_uid: rsp.imp_uid});
				paymentStatus.value = 'SUCCESS';
				alert('결제가 성공적으로 처리되었습니다.');
				if (confirm("마이페이지로 이동하시겠습니까?")) {
					// 예를 클릭했을 때 실행될 코드
					router.push('/user/mypage');
				} else {
					router.go(-1); // 이전 페이지로 이동
				}
				} else {
				console.error('결제 실패:', rsp.error_msg);
				paymentStatus.value = 'FAILED';
				alert(rsp.error_msg);
				}
		});
	} catch (error) {
		// 에러 처리: error가 객체일 수도, 문자열일 수도 있으므로 확인 후 처리
		if (error && error.message) {
			console.error('에러 발생:', error.message);
			alert(`결제 처리 중 오류가 발생했습니다: ${error.message}`);
		} else {
			console.error('예기치 않은 에러 발생:', error);
			alert('결제 처리 중 오류가 발생했습니다.');
		}
	}
};

	
</script>
<style scoped>
	.paymodal-bg{
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;

		z-index: 1000;
	}
	.paymodal-container{
		width: 1300px;
		background-color: white;
		height: 100%;
		display: flex;
		flex-direction: column;
		gap: 1rem;

		padding: 32px 50px;
	}
	.paymodal-clientInfo{
		display: grid;
		grid-template-columns: 1fr 2fr;

		gap : 20px;
	}
	.paymodal-rules{
		width: 100%;
	}
	.buttonArea{
		width: 100%;

		display: flex;
		justify-content: center;
		align-items: center;

		gap : 22px;
	}
	.buttonArea button{
		width: 284px;
		height: 68px;
		border-radius: 50px;

		color : white;

		cursor: pointer;
	}

	.buttonArea :nth-child(1){
		background-color: #2986FF;
		border: 3px solid #2986FF;
	}
	.buttonArea :nth-child(2){
		background-color: #BDBDBD;
		border: 3px solid #BDBDBD;
	}

	.buttonArea button:hover{
		background-color: white;
		color : black;

		transition: all 0.1s;
	}
</style>