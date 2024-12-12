<template>
	<div class="index-postbox">
		<div class="index-postbox-title">
			<h3>커뮤니티 반려동물 자랑</h3>
			<p>#귀여운 댕댕이의 멋진 모습을 자랑해주세요</p>
		</div>
		<div class="index-category-onlyController">
			<div class="index-controller">
				<button><</button>
				<button>></button>
			</div>
		</div>
		<div class="index-community-cardzone">
			<div class="index-community-card" v-for="value in 4" :key="value">
				<div class="index-community-card-img"></div>
			</div>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.index-category-onlyController{
		width: 100%;
		display: flex;
		justify-content: flex-end;

		padding : 0 100px;
		margin : 20px 0;
	}

	.index-community-cardzone{
		width: 100%;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		grid-auto-rows: 300px;

		gap : 30px;

		justify-items: center;
		align-items: flex-end;
	}

	.index-community-card{
		width: 100%;
		height: 100%;
	}

	.index-community-card-img{
		width: 100%;
		height: 100%;

		background-color: beige;

		border-radius: 50px;
	}
	/* 반응형 : 1600px */
	@media (max-width : 1600px){
		.index-community-cardzone{
			height: 600px;
			grid-template-columns: 1fr 1fr;
			grid-template-rows: 1fr 1fr;
		}
	}

	/* 반응형 : 1023px */
	@media (max-width : 1023px){

	}

	/* 반응형 : 599px 이하 */
	@media (max-width : 599px){
		.index-community-cardzone{
			padding:0 100px;
			height: 800px;
			grid-template-columns: none;
			grid-template-rows: repeat(4, 1fr);
		}
	}
</style>
