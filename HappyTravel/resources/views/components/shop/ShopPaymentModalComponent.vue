<template>
	<div class="paymodal-bg">
		<div class="paymodal-container">
			<div class="paymodal-clientInfo">
				<ShopModalClientInfo/>
			</div>
		</div>
	</div>
</template>
<script setup>
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
	}
	.paymodal-container{
		width: 1300px;
		height: 100%;
		background-color: white;

		display: flex;
		flex-direction: column;
	}
</style>