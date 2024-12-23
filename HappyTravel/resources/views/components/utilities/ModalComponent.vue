<template>
	<div class="modal-container">
		<div class="modal-background">
			<h1 class="modal-title">
				{{ props.data.title }}
			</h1>
			<h3 class="modal-content">
				{{ props.data.content }}
			</h3>
			<div class="modal-warning" v-if="'warningContent' in props.data">
				<div class="modal-warning-deco"></div>
				<div class="modal-warning-textArea">
					<div class="modal-warning-title">
						<div class="modal-warning-title-icon" ></div>
						<h2 class="modal-warnint-title-title">경고</h2>
					</div>
					<div class="modal-warning-content">
						<h4>{{ props.data.warningContent }}</h4>
					</div>
				</div>			
			</div>
			<div class="modal-btnArea">
				<button class="modal-btn modal-btnCancel" @click="props.data.onClickCancel">뒤로가기</button>
				<button class="modal-btn modal-btnConfirm" @click="props.data.onClickConfirm">수락하기</button>
			</div>
		</div>
	</div>
</template>
<script setup>
	import { defineProps } from 'vue';

	const props = defineProps({
		data : Object
	});
</script>
<style scoped>
	/* 모달 컨테이너 */
	.modal-container{
		position: fixed;
		width: 100%;
		height: 100%;
		background-color: rgb(0, 0, 0, 0.3);
		/* opacity: 0.3; */
		left:0;
		top:0;

		z-index: 100;

		display: flex;

		justify-content: center;
		align-items: center;
	}

	/* 모달 배경 */
	.modal-background{
		width: 60%;
		height: 60%;

		background-color: #ffffff;

		z-index: 120;

		display: flex;
		flex-direction: column;
		justify-content: space-between;
		align-items: center;

		padding : 50px 50px;
	}
	/* 모달 빨간 박스 */
	.modal-warning{
		width: 100%;
		height: 30%;

		background-color: #FFE8D9;

		display: flex;
	}

	/* 모달 왼쪽에 꾸미는 박스 */
	.modal-warning-deco{
		width: 10px;
		height: 100%;

		background-color: red;

		margin-right: 15px;
	}

	/* 모달 빨간 박스 안에서 텍스트 넣는 지역 */
	.modal-warning-textArea{
		padding: 10px 0px;

		display: grid;
		grid-template-rows: 1fr 2fr;
	}

	/* 모달 빨간박스 제목, 아이콘 영역 */
	.modal-warning-title{
		display: flex;
		gap : 10px;
		align-items: center;
	}

	.modal-warning-title-icon{
		width: 50px;
		height: 50px;

		background-image: url('/developImg/warning.png');
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	/* 모달 빨간박스 콘텐츠 영역 */
	.modal-warning-content{
		align-self: center;
	}

	/* 모달 버튼 구역 */
	.modal-btnArea{
		display: flex;
		gap : 1rem;
	}

	.modal-btn{
		width: 200px;
		height: 40px;

		font-size: 1.2rem;

		cursor: pointer;

		border-radius: 50px;
	}

	.modal-btnCancel{
		background-color: #BDBDBD;
		color: white;
		border: 1px solid #BDBDBD;
	}
	
	.modal-btnCancel:hover{
		background-color: white;
		color: black;

		transition: all 0.1s;
	}

	.modal-btnConfirm{
		background-color: #E12D39;
		color: white;
		border: 1px solid #E12D39;
	}

	.modal-btnConfirm:hover{
		background-color: white;
		color: black;

		transition: all 0.1s;
	}
</style>