<template>
	<div class="paymodal-bg">
		<div class="paymodal-container">
			<div class="paymodal-clientInfo">
				<ShopModalClientInfo/>
				<ShopModalAnimalsInfo/>
			</div>
		</div>
	</div>
</template>
<script setup>
	import ShopModalAnimalsInfo from './shop_modal/ShopModalAnimalsInfo.vue';
import ShopModalClientInfo from './shop_modal/ShopModalClientInfo.vue';
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

		overflow: auto;
	}
	.paymodal-container{
		width: 1300px;
		height: 100%;
		background-color: white;

		display: grid;
		grid-template-rows: 1fr 1fr 0.1fr;

		padding: 32px 50px;
	}
	.paymodal-clientInfo{
		display: grid;
		grid-template-columns: 1fr 2fr;

		gap : 20px;
	}
</style>