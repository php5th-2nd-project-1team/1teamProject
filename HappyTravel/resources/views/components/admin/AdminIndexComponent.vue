<template>
	<div class='index-container'>
		<!-- 타이틀 부분 -->
		<h1>메인</h1>
		<h2>2025년 01월 16일 기준 가입자는 3명, 탈퇴자는 4명입니다.</h2>

		<!-- 유저 부분 -->
		<div class="index-users containers">
			<div class="index-users-title containers-row">
				<h3>유저</h3>
				<p>최신 가입 유저 5명</p>
				<p>해당 상세 페이지로</p>
			</div>
			<table>
				<thead>
					<tr>
						<th>id</th>
						<th>계정</th>
						<th>이름</th>
						<th>닉네임</th>
						<th>성별</th>
						<th>전화번호</th>
						<th>이메일</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="i in 5" :key="i">
						<td>1</td>
						<td>testid1</td>
						<td>김삐삐</td>
						<td>아이고아이고</td>
						<td>남자</td>
						<td>010-3456-7890</td>
						<td>example@test.com</td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- 포스트 -->
		<div class="index-posts-title containers-row">
			<h3>포스트</h3>
			<p>최신 댓글 갱신 기준 5개</p>
			<p>해당 상세 페이지로</p>
		</div>
		<table>
			<thead>
				<tr>
					<th>id</th>
					<th>이름</th>
					<th>지역</th>
					<th>댓글 수</th>
					<th>댓글작성일자</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="i in 5" :key="i">
					<td>1</td>
					<td>부목아아아아</td>
					<td>평양 직할시</td>
					<td>99</td>
					<td>2025-01-32</td>
				</tr>
			</tbody>
		</table>

		<!-- 문의 -->
		<div class="index-question-title containers-row">
			<h3>문의</h3>
			<p>최신 작성 순 5개</p>
			<p>해당 상세 페이지로</p>
		</div>
		<table>
			<thead>
				<tr>
					<th>id</th>
					<th>제목</th>
					<th>내용</th>
					<th>문의 작성일자</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="i in 5" :key="i">
					<td>1</td>
					<td>부목아아아아</td>
					<td>평양 직할시</td>
					<td>99</td>
					<td>2025-01-32</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>
<script setup>

</script>
<style>
	.index-container{
		width: 100%;
		min-height: 100%;

		padding: 1rem;

		display: flex;
		flex-direction: column;

		gap: 1rem;
	}
	.containers{
		display: flex;
		flex-direction: column;
		gap: 1rem;
	}
	.containers-row{
		display: flex;
		flex-direction: row;

		justify-content: space-between;
		align-items: center;
		gap: 1rem;
	}
	table{
		border-collapse:collapse;
	}
	tr, th, td{
		border: 1px solid black;
		text-align: center;
	}
</style>