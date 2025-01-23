<template>
	<!-- 관리자 유저 관리 컨테이너 -->
	<div class="admin-user-container">
		<!-- 페이지 제목 -->
		<h1>관리자 목록</h1>

		<!-- 유저 정보 테이블 -->
		<table>
			<!-- 테이블 헤더 -->
			<thead>
				<tr>
					<th>id</th>
					<th>계정</th>
					<th>닉네임</th>
					<th>등급</th>
					<th>등록 일자</th>
					<th>계정 활성화 여부</th>
				</tr>
			</thead>
			<!-- 테이블 본문: 최대 10개의 더미 데이터 표시 -->
			<tbody>
				<tr v-for="i in 10" :key="i">
					<td>{{ i }}</td>
					<td>account{{ i }}</td>
					<td>닉네임{{ i }}</td>
					<td>0{{ i }}</td> <!-- TODO DB에 등급컬럼 추가해두기 -->
					<td>2024-12-16</td>
					<td>{{ i % 3 === 0 ? '불' : '가' }}</td> <!-- TODO creatd_at이랑 updated_at 같으면 '불', 다르면 '가'로 적어주기 -->
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