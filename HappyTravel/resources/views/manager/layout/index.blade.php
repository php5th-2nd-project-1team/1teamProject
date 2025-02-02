@extends('manager.base')

@section('additional_css')
<style>
	.dashboard-header {
		background-color: #f8f9fa;
		padding: 20px 0;
		margin-bottom: 20px;
		border-bottom: 1px solid #dee2e6;
	}
	.dashboard-title {
		font-size: 2rem;
		font-weight: bold;
		color: #2c3e50;
		margin: 0;
	}
	.dashboard-subtitle {
		color: #6c757d;
		margin-top: 5px;
		font-size: 1rem;
	}
	.dashboard-container {
		padding: 0 15px;
	}
	.stats-summary {
		background-color: white;
		padding: 15px;
		border-radius: 8px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		margin-bottom: 20px;
	}
	.table-section {
		background-color: white;
		padding: 15px;
		border-radius: 8px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		margin-bottom: 20px;
	}
	.table-header {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		margin-bottom: 15px;
		padding-bottom: 10px;
		border-bottom: 1px solid #dee2e6;
	}
	.table-title-section {
		display: flex;
		flex-direction: column;
		gap: 8px;
	}
	.table-description {
		color: #495057;
		font-size: 1rem;
		margin: 0;
		font-weight: 500;
	}
	.detail-link {
		color: #007bff;
		text-decoration: none;
		white-space: nowrap;
	}
	.detail-link:hover {
		text-decoration: underline;
	}
	.clickable-row {
		cursor: pointer;
		transition: background-color 0.2s;
	}
	.clickable-row:hover {
		background-color: #f5f5f5 !important;
	}
	.table-section h3 {
		margin: 0;
		color: #2c3e50;
		font-weight: 600;
	}
</style>
@endsection

@section('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const rows = document.querySelectorAll('.clickable-row');
		rows.forEach(row => {
			row.addEventListener('click', function() {
				window.location.href = this.dataset.href;
			});
		});
	});
</script>
@endsection

@section('content')
<div class="dashboard-header">
	<div class="container-fluid">
		<h1 class="dashboard-title">관리자 대시보드</h1>
		<p class="dashboard-subtitle">시스템 현황 및 주요 데이터를 한눈에 확인하세요.</p>
	</div>
</div>

<div class="dashboard-container">
	<!-- 통계 정보 -->
	<div class="stats-summary">
		<h4>{{ date('Y년 m월 d일') }} 기준</h4>
		<p>가입자: 150명, 탈퇴자: 23명</p>
	</div>

	<!-- 유저 관리 테이블 -->
	<div class="table-section">
		<div class="table-header">
			<div class="table-title-section">
				<h3>유저 관리</h3>
				<p class="table-description">최신 가입 유저 5명 까지</p>
			</div>
			<a href="#" class="detail-link">해당 상세 페이지로 →</a>
		</div>
		<div class="table-responsive">
			{{-- Bootstrap의 table-striped는 테이블 행들 번갈아가면서 다른 배경색 넣어주는거임 --}}
			{{-- 테이블 읽기 쉽게 만들어주고 행 구분하기 편하게 해줌 --}}
			{{-- 보통 짝수 행은 연한 회색, 홀수 행은 흰색으로 나옴 --}}
			{{-- 이하 동일 --}}
			<table class="table table-striped">
				<thead>
					<tr>
						<th>유저 번호</th>
						<th>계정</th>
						<th>이름</th>
						<th>닉네임</th>
						<th>성별</th>
						<th>전화번호</th>
						<th>이메일</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr class="clickable-row" data-href="/manager/users/{{ $user->user_id }}">
						<td>{{ $user->user_id }}</td>
						<td>{{ $user->account }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->nickname }}</td>
						<td>{{ $user->gender }}</td>
						<td>{{ $user->phone_number }}</td>
						<td>{{ $user->email }}</td>
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>

	<!-- 포스트 테이블 -->
	<div class="table-section">
		<div class="table-header">
			<div class="table-title-section">
				<h3>포스트</h3>
				<p class="table-description">최신 댓글 갱신 기준 5개 까지</p>
			</div>
			<a href="#" class="detail-link">해당 상세 페이지로 →</a>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>이름</th>
						<th>지역</th>
						<th>댓글 수</th>
						<th>댓글작성일자</th>
					</tr>
				</thead>
				<tbody>
					@foreach($posts as $post)
					<tr class="clickable-row" data-href="/manager/posts/{{ $post->post_id }}">
						<td>{{ $post->post_id }}</td>
						<td>{{ $post->post_title }}</td>
						<td>{{ $post->post_local_name }}</td>
						<td>{{ $post->comment_count }}</td>
						<td>{{ $post->comment_created_at }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>

	<!-- 문의 테이블 -->
	<div class="table-section">
		<div class="table-header">
			<div class="table-title-section">
				<h3>문의사항</h3>
				<p class="table-description">최신 작성 순 5개</p>
			</div>
			<a href="#" class="detail-link">해당 상세 페이지로 →</a>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>제목</th>
						<th>내용</th>
						<th>문의 작성일자</th>
					</tr>
				</thead>
				<tbody>
					<tr class="clickable-row" data-href="/manager/inquiries/1">
						<td>1</td>
						<td>로그인 문의</td>
						<td>로그인이 되지 않습니다. 비밀번호 재설정은 어떻게 하나요?</td>
						<td>2024-02-01</td>
					</tr>
					<tr class="clickable-row" data-href="/manager/inquiries/2">
						<td>2</td>
						<td>결제 오류</td>
						<td>결제 진행 중 오류가 발생했습니다. 확인 부탁드립니다.</td>
						<td>2024-02-01</td>
					</tr>
					<!-- 추가 더미 데이터 -->
				</tbody>
			</table>
		</div>
	</div>

	<!-- 신고 테이블 -->
	<div class="table-section">
		<div class="table-header">
			<div class="table-title-section">
				<h3>신고</h3>
				<p class="table-description">최신 작성 순 5개</p>
			</div>
			<a href="#" class="detail-link">해당 상세 페이지로 →</a>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>신고자</th>
						<th>신고사유</th>
						<th>신고목록</th>
						<th>처리여부</th>
					</tr>
				</thead>
				<tbody>
					<tr class="clickable-row" data-href="/manager/reports/1">
						<td>1</td>
						<td>user123</td>
						<td>부적절한 내용</td>
						<td>게시글</td>
						<td>처리중</td>
					</tr>
					<tr class="clickable-row" data-href="/manager/reports/2">
						<td>2</td>
						<td>kim456</td>
						<td>스팸</td>
						<td>댓글</td>
						<td>완료</td>
					</tr>
					<!-- 추가 더미 데이터 -->
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection 