<template>
	<div class="clientinfo-container">
		<div class="clientinfo-title">
			<p>예약자 정보 확인</p>
		</div>
		<div class="clientinfo-name clientinfo">
			<p>예약자 성함</p>
			<input type="text" name="name" id="name" :value=$store.state.auth.userInfo.name readonly>
		</div>
		<div class="clientinfo-phone clientinfo">
			<p>연락 가능한 연락처</p>
			<input type="text" name="phone" id="phone" :value=$store.state.auth.userInfo.phone_number readonly>
		</div>
		<div class="clientinfo-count clientinfo">
			<p>참여 인원 수</p>
			<div class="clientinfo-buttonarea">
				<button @click="subPeopleCount"><</button>
				<input type="number" name="count" id="count" min="1" v-model="peopleCount">
				<button @click="addPeopleCount">></button>
			</div>
		</div>
		<div class="clientinfo-price clientinfo">
			<p>결제 금액</p>
			<p>{{ $store.state.shop.shopBoardDetail.class_price }}</p>
		</div>
	</div>
</template>
<script setup>

import { computed, ref } from 'vue';
import { useStore } from 'vuex';

	const store = useStore();

	const peopleCount = computed(() => store.state.shop.peopleCount);


	function addPeopleCount(){
		store.commit('shop/setPeopleCountUp');
	}

	function subPeopleCount(){
			store.commit('shop/setPeopleCountDown');
	}

</script>
<style scoped>
	input:focus{
		outline: none;
	}

	.clientinfo-container{
		display: flex;
		flex-direction: column;;
		gap : 1rem;

		width: 100%;
		height: 100%;
	}

	.clientinfo{
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		gap : 1rem;
	}

	.clientinfo-title{
		font-size: 1.5rem;
		font-family: 'GmarketSansBold';
	}

	.clientinfo input{
		width: 100%;
		height: 55px;
		padding-left: 1rem;
	}

	.clientinfo-buttonarea{
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap : 20px;

		width: 100%;
		height: 55px;
	}
	.clientinfo-buttonarea button{
		width: 83px;
		height: 100%;
	}
	.clientinfo-buttonarea input{
		width: 183px;
		height: 100%;
		padding: 0;

		text-align: center;
	}
	.clientinfo-price :nth-child(2){
		font-size: 2rem;
	}

	/* input:number 상하 화살표 제거하는 코드 */
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
</style>