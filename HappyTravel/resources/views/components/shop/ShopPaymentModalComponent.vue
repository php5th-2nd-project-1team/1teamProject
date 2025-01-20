<template>
	<div class="paymodal-bg">
		<div class="paymodal-container" style="overflow: scroll;">
			<div class="paymodal-clientInfo">
				<ShopModalClientInfo/>
				<ShopModalAnimalsInfo/>
			</div>
			<div class="paymodal-rules">
				<ShopModalRule/>
			</div>
			<div class="buttonArea">
				<button @click="onClickReservation()">예약하기</button>
				<button @click="store.commit('shop/setIsModalOpen', false)">뒤로가기</button>
			</div>
		</div>
	</div>
</template>
<script setup>
	import ShopModalAnimalsInfo from './shop_modal/ShopModalAnimalsInfo.vue';
	import ShopModalClientInfo from './shop_modal/ShopModalClientInfo.vue';
	import ShopModalRule from './shop_modal/ShopModalRule.vue';
	import { useStore } from 'vuex';
	const store = useStore();

	function onClickReservation(){

	}
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