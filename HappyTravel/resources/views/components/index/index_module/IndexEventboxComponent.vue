<template>
	<div class="index-eventbox">
			<div class="index-event-controller">
				<div class="index-event-comment">
					<p>즐겁게 반려동물과 여행 시작</p>
				</div>
				<h1>여행여행 반려동물과 즐거운 여행👍</h1>
				<p>자세히 보기</p>
				<div class="index-event-buttonArea">
					<button class="index-event-nextbtn">←</button>
						<button class="index-event-btn" v-for="value in 5" :key="value"></button>
					<button class="index-event-nextbtn">→</button>
				</div>
			</div>
			<div class="index-event-viewer">
				<div class="index-event-img" style="background-image: url('/developImg/index-event-sample.png');">
				</div>
			</div>
		</div>
</template>
<script setup>

</script>
<style scoped>
	.index-eventbox{
		width: 80%;
		height: 500px;  
		background: linear-gradient(#D2EEFF, #92D4FF);

		display: grid;
		grid-template-columns: 1fr 2fr;

		border-radius: 80px;

		padding: 0 2rem;
	}

	.index-event-controller{
		display: flex;
		flex-direction: column;
		justify-content: center;

		gap: 10px;

		padding-left: 16px;
	}

	.index-event-comment{
		background-color: black;
		color: white;
		width: 250px;
		height: 32px;
		display: flex;
		justify-content: center;
		align-items: center;

		border-radius: 200px;
		border-bottom-left-radius: 0%;
	}

	.index-event-buttonArea{
		display: flex;
		justify-content: space-between;
		align-items: center;
		width: 200px;
	}

	.index-event-nextbtn{
		background-color: white;
		border: 0.05px solid black;
		border-radius: 100%;
		font-size: 0.6rem;
		padding: 5px;
	}

	.index-event-btn{
		background: #ECECEC;
		width: 1.2rem;
		height: 1.2rem;
		border: none;
		border-radius: 100%;
	}

	.index-event-activebtn{
		background-color: #2986FF;
	}

	.index-event-viewer{
		width: 100%;
		height: 100%;

		padding : 80px;
	}

	.index-event-img{
		background-color: white;
		width: 100%;
		height: 100%;

		border-radius: 50px;

		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}

	/* 반응형 : 1023px */
	@media (max-width : 1023px){
		.index-eventbox{
			grid-template-columns: none;
			grid-template-rows: 1fr 1fr;
		}

		.index-event-viewer{
			padding: 20px;
		}
	}

	/* 반응형 : 599px 이하 */
	@media (max-width : 599px){
		.index-eventbox{
			width: 90%;
			padding: 0;
		}
		.index-event-comment{
			width: 200px;
		}
		.index-event-comment p{
			font-size: 0.7rem;
		}
		h1{
			font-size: 1.5rem;
		}
	}
</style>