<template>
	<div class="index-commentbox">
		<p>펫브리즈</p>
		<p>반려동물과 함께 여행을 떠나자</p>
		<p>"왈왈(여행) 으르렁(신나요!) 컹컹(야호)"</p>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.index-commentbox{
		display: flex;
		flex-direction: column;
		align-items: center;

		font-weight: 900;
		font-size: 2.5rem;
	}

	.index-commentbox :last-child{
		margin: 20px 0;
	}

	/* 반응형 : 1439px */
	@media (max-width : 1439px){
		.index-commentbox{
			font-size: 2rem;
		}
	}

	/* 반응형 : 1023px */
	@media (max-width : 1023px){
		.index-commentbox{
			font-size: 1.5rem;
		}
	}

	/* 반응형 : 599px 이하 */
	@media (max-width : 599px){
		.index-commentbox{
			font-size: 1rem;
		}
	}
</style>