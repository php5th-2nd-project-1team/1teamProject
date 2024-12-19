<template>
	<div class="index-mediabox">
		<iframe src="https://www.youtube.com/embed/mTF9Yjszwx4?si=z6KjuXvEmH21F_gq" 
		title="YouTube video player" 
		frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
		referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
		<p>멍멍냥냥멍멍냥냥멍멍냥냥멍멍냥멍멍냥<br>반려동물과 함께 여행을</p>
		<button @click="$router.push('/about')">더 알아보기</button>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.index-mediabox{
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	iframe{
		width: 1200px;
		height: 600px;
	}

	.index-mediabox p{
		text-align: center;
		margin-top: 40px;
		margin-bottom: 20px;
		font-size: 2.25rem;
		font-weight: 500;
	}

	.index-mediabox button{
		background-color: #2986FF;
		border: none;
		border-radius: 500px;
		box-shadow: 0 3px 3px 0.5px black;

		color: white;
		font-size: 2.2rem;

		width: 300px;
		height: 80px;
	}

	.index-mediabox button:hover{
		background-color: white;
		color: black;
		border: 2px solid #2986FF;
		cursor: pointer;

		transition: background-color 0.1s;
	}

	/* 반응형 : 1439px */
	@media (max-width : 1439px){
		iframe{
			width: 1000px;
			height: 400px;
		}
		.index-mediabox p{
			font-size: 2rem;
		}
	}

	/* 반응형 : 1023px */
	@media (max-width : 1023px){
		iframe{
			width: 600px;
			height: 300px;
		}
		.index-mediabox p{
			font-size: 1.5rem;
		}

		.index-mediabox button{
			border-radius: 250px;

			color: white;
			font-size: 1.1rem;

			width: 150px;
			height: 40px;
		}
	}

	/* 반응형 : 599px 이하 */
	@media (max-width : 599px){
		iframe{
			width: 300px;
			height: 150px;
		}
		.index-mediabox p{
			font-size: 1rem;
			font-weight: 800;
		}
	}
</style>