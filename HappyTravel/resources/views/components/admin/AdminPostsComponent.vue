<template>
	<!-- 관리자 유저 관리 컨테이너 -->
	<div class="admin-user-container">
		<!-- 페이지 제목 -->
		<h1>포스트 목록</h1>

		<!-- 유저 정보 테이블 -->
		<table>
			<!-- 테이블 헤더 -->
			<thead>
				<tr>
					<th>id</th>
					<th>제목</th>
					<th>지역</th>
					<th>콘텐츠</th>
					<th>조회수</th>
					<th>좋아요 수</th>
					<th>상태</th>
				</tr>
			</thead>
			<!-- 테이블 본문: 최대 10개의 더미 데이터 표시 -->
			<tbody>
				<tr v-for="i in 10" :key="i">
					<td>{{ i }}</td>
					<td>제목{{ i }}</td>
					<td>지역{{ i }}</td>
					<td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos sit et rerum. Praesentium dolorem architecto deleniti. Aliquid, aliquam expedita nesciunt magnam facilis, praesentium provident incidunt unde quas quae tempore qui!{{ i }}</td>
					<td>100</td>
					<td>{{ 999/i }}</td>
					<td>{{ i%3 === 0 ? '공개' : '비공개' }}</td>
				</tr>
			</tbody>
		</table>

		<!-- 페이지네이션 버튼 그룹 -->
		<!-- TODO 페이지네이션 새롭게 꾸미기 -->
		<div class="admin-user-pagination">
			<button>이전</button>
			<button>1</button>
			<button>2</button>
			<button>3</button>
			<button>4</button>
			<button>5</button>
			<button>다음</button>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.admin-user-container{
		display: flex;
		flex-direction: column;
		gap: 1rem;

		justify-content: center;
		align-items: center;

		width: 100%;
		padding : 1rem;
	}
	table{
		width: 100%;
		border-collapse:collapse;
	}
	tr, th, td{
		border: 1px solid black;
		text-align: center;
	}

	td, th{
		padding: 0.5rem;
	}
	
	tbody tr:nth-child(even) {
    	background-color: #c1c1c1;  /* 밝은 회색 */
		
	}
</style>