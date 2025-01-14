<template>
	<div class="shopDetail-info-container">
		<div class="shopDetail-info-img" style="background-image: url('/developImg/about-three1.png');"></div>
	</div>
</template>
<script setup>

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
</style>