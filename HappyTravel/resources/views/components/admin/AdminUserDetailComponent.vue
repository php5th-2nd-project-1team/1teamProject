<template>
	<div class="admin-user-detail-container">
		<h1>유저 상세</h1>

		<div class="admin-user-detail-accountArea user-area">
			<p>유저번호 : </p>
			<p>1</p>
		</div>
		<div class="admin-user-detail-accountArea user-area">
			<p>계정 : </p>
			<p>account1</p>
		</div>
		<div class="admin-user-detail-nameArea user-area">
			<p>이름 : </p>
			<p>성이름1</p>
		</div>
		<div class="admin-user-detail-nicknameArea user-area">
			<p>닉네임 : </p>
			<p>닉네임1</p>
		</div>
		<div class="admin-user-detail-genderArea user-area">
			<p>성별 : </p>
			<p>남자</p>
		</div>
		<div class="admin-user-detail-addressArea">
			<div class="admin-user-detail-addressArea-codeArea addressArea">
				<p>우편번호 : </p>
				<p>12345</p>
			</div>
			<div class="admin-user-detail-addressArea-addressArea addressArea">
				<p>주소 : </p>
				<p>주소1</p>
			</div>
			<div class="admin-user-detail-addressArea-detailArea addressArea">
				<p>상세주소 : </p>
				<p>상세주소1</p>
			</div>
		</div>
		<div class="admin-user-detail-phoneArea user-area">
			<p>전화번호 : </p>
			<p>010-1234-5678</p>
		</div>
		<div class="admin-user-detail-emailArea user-area">
			<p>이메일 : </p>
			<p>test@test.com</p>
		</div>
		<div class="admin-user-detail-profileArea user-area">
			<p>프로필</p>
			<img src="/developImg/about-three1.png" alt="프로필">
		</div>
		<div class="button-area">
			<button>탈퇴 처리</button>
			<button>징계 처리</button>
			<button>징계 해제 처리</button>
			<button>비밀번호 초기화</button>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.admin-user-detail-container{
		display: flex;
		flex-direction: column;
		gap: 10px;

		padding : 1rem;
	}
	.user-area{
		border: 1px solid #000;
		padding: 1rem;

		width: 100%;

		display: flex;
		align-items: center;
		gap: 1rem;
	}
	.admin-user-detail-addressArea{
		border: 1px solid #000;
		padding: 1rem;

		width: 100%;

		display: flex;
		flex-direction: column;
		justify-content: center;
		gap: 1rem;
	}
	.addressArea{
		display: flex;
		gap: 1rem;
	}

	.addressArea p{
		display: flex;
		align-items: flex-end;
	}
	.button-area{
		display: flex;
		justify-content: center;
		gap: 1rem;
	}
	.button-area button{
		padding: 1rem;
	}
</style>