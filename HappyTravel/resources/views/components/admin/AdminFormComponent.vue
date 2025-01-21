<template>
	<div class="admin-container">
		<div class="admin-sidebar">
			<div class="logo">
				로고임
			</div>
			<div class="user">
				<h2>유저</h2>
				<p>신고</p>
				<p>징계</p>
			</div>
			<div class="admin">
				<h2>관리자</h2>
				<p>관리자 등록</p>
			</div>
			<div class="post">
				<h2>포스트</h2>
				<p>포스트 작성</p>
			</div>
			<div class="issue">
				<h2>문의사항</h2>
			</div>
			<div class="notice">
				<h2>공지사항</h2>
				<p>공지사항 작성</p>
			</div>
			<div class="shop">
				<h2>상품</h2>
				<p>상품 등록</p>
			</div>
			<div class="setting">
				<h2>사이트 설정</h2>
			</div>
			<div class="account">
				<h2>로그인</h2>
			</div>
		</div>	
		<router-view></router-view>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.admin-container{
		display: grid;
		grid-template-columns: 300px 1fr;
		height: 100%;
	}

	/* 사이드바 부분 */
	.admin-sidebar{
		width: 100%;
		min-height: 100vh;
		background-color: gray;

		padding-left : 1rem;
		padding-top: 1rem;

		display: flex;
		flex-direction: column;
		gap : 1rem;
	}
</style>