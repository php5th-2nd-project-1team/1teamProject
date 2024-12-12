<template>
<div class="index-postbox">
	<div class="index-postbox-title">
			<h3>개 끝내주는 상품</h3>
			<p>#원하시는 상품을 찾아보세요</p>
		</div>
		<div class="index-category">
			<div class="index-category-category">
				<p>숙소</p>
				<p>식음료</p>
				<p>관광지</p>
				<p>동물병원</p>
			</div>
			<div class="index-controller">
				<button><</button>
				<button>></button>
			</div>
		</div>
		<div class="index-cardzone">
			<div class="index-shop-card" v-for="value in 3" :key="value">
				<div class="index-shop-card-img">
					<p>sale</p>
					<p>new</p>
				</div>
				<p>상품이름</p>
				<p class="abc" data-descr="100,000원">200,000원</p>
				<div class="index-card-btnArea">
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	/* 여행지 상품 */
	.abc[data-descr]::after{
		content: attr(data-descr);
		text-decoration: line-through;
	}

	.index-shop-card{
		border-radius: 50px;
		width: 100%;
		height: 100%;

		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.index-shop-card-img{
		display: flex;
		width: 100%;
		padding-bottom: 40%;
		border-radius: 50px;

		justify-content: flex-end;

		background-color: rgb(73, 63, 54);

		margin-bottom: 20px;
	}

	.index-shop-card-img p{
		color: white;
		background-color: orange;

		border-radius: 100%;

		width: 3rem;
		height: 3rem;

		margin : 15px 10px;

		display: flex;
		justify-content: center;
		align-items: center;

		line-height: 16px;
	}
</style>