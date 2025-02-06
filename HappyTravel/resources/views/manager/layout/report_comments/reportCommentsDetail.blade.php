@extends('manager.base')

@section('additional_css')
<style>
	.report-detail-header {
		background-color: #f8f9fa;
		padding: 25px 0;
		margin-bottom: 30px;
		border-bottom: 1px solid #dee2e6;
		box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	}
	.report-detail-title {
		font-size: 2rem;
		font-weight: bold;
		color: #2c3e50;
		margin: 0;
	}
	.report-detail-container {
		padding: 0 15px;
	}
	.report-detail-section {
		background-color: white;
		padding: 40px;
		border-radius: 12px;
		box-shadow: 0 2px 15px rgba(0,0,0,0.1);
		margin-bottom: 30px;
	}
	.report-link {
		display: inline-block;
		color: #3498db;
		text-decoration: none;
		margin-bottom: 20px;
		font-size: 1.1rem;
	}
	.report-link:hover {
		text-decoration: underline;
		color: #2980b9;
	}
	.report-link i {
		margin-right: 8px;
	}
	.info-group {
		margin-bottom: 30px;
	}
	.info-row {
		display: flex;
		margin-bottom: 15px;
		border-bottom: 1px solid #eee;
		padding-bottom: 15px;
	}
	.info-label {
		width: 150px;
		font-weight: 600;
		color: #2c3e50;
	}
	.info-value {
		flex: 1;
		color: #34495e;
	}
	.status-badge {
		padding: 6px 12px;
		border-radius: 15px;
		font-size: 0.9rem;
		font-weight: 500;
		display: inline-block;
	}
	.status-pending {
		background-color: #ffeeba;
		color: #856404;
	}
	.status-completed {
		background-color: #c3e6cb;
		color: #155724;
	}
	.punishment-section {
		margin-top: 40px;
		padding-top: 20px;
		border-top: 2px solid #eee;
	}
	.section-title {
		font-size: 1.5rem;
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 20px;
	}
	.form-group {
		margin-bottom: 20px;
	}
	.form-label {
		display: block;
		margin-bottom: 8px;
		font-weight: 500;
		color: #2c3e50;
	}
	.form-select {
		width: 200px;
		padding: 8px;
		border-radius: 4px;
		border: 1px solid #ced4da;
		margin-bottom: 15px;
	}
	.form-input {
		width: 100px;
		padding: 8px;
		border-radius: 4px;
		border: 1px solid #ced4da;
	}
	.form-textarea {
		width: 100%;
		padding: 8px;
		border-radius: 4px;
		border: 1px solid #ced4da;
		min-height: 100px;
	}
	.action-buttons {
		margin-top: 30px;
		display: flex;
		gap: 15px;
	}
	.btn {
		padding: 10px 25px;
		border-radius: 8px;
		font-weight: 500;
		cursor: pointer;
		display: flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
	}
	.btn-primary {
		background-color: #e74c3c;
		border: none;
		color: white;
	}
	.btn-secondary {
		background-color: #95a5a6;
		border: none;
		color: white;
	}
	.btn:hover {
		opacity: 0.9;
	}
	.info-row.detail-reason {
		display: block;
	}
	.detail-reason .info-label {
		width: 100%;
		margin-bottom: 10px;
		font-size: 1.1rem;
		border-bottom: 2px solid #eee;
		padding-bottom: 10px;
	}
	.detail-reason .info-value {
		padding: 15px;
		background-color: #f8f9fa;
		border-radius: 8px;
		white-space: pre-line;
		line-height: 1.6;
		min-height: 100px;
	}
	.comment-content {
		background-color: #fff;
		border: 1px solid #e1e8ed;
		border-radius: 8px;
		padding: 20px;
		margin-bottom: 20px;
	}
	.comment-content .comment-header {
		display: flex;
		justify-content: space-between;
		margin-bottom: 15px;
		padding-bottom: 10px;
		border-bottom: 1px solid #eee;
	}
	.comment-content .user-info {
		font-weight: 500;
		color: #2c3e50;
	}
	.comment-content .comment-date {
		color: #7f8c8d;
		font-size: 0.9em;
	}
	.comment-content .comment-text {
		color: #34495e;
		line-height: 1.6;
		white-space: pre-line;
	}
</style>
@endsection

@section('content')
<div class="report-detail-header">
	<div class="container-fluid">
		<h1 class="report-detail-title">댓글 신고 상세</h1>
	</div>
</div>

<div class="report-detail-container">
	<div class="report-detail-section">
		<a href="{{ $url }}" class="report-link">
			<i class="fas fa-external-link-alt"></i>
			해당 게시물로 이동
		</a>

		<div class="info-group">
			<div class="info-row">
				<div class="info-label">신고 ID</div>
				<div class="info-value">{{ $report->report_id }}</div>
			</div>
			<div class="info-row">
				<div class="info-label">신고자 ID</div>
				<div class="info-value">{{ $report->user->account }}</div>
			</div>
			<div class="info-row">
				<div class="info-label">신고자 이름</div>
				<div class="info-value">{{ $report->user->name }}</div>
			</div>
			<div class="info-row">
				<div class="info-label">댓글 카테고리</div>
				<div class="info-value">{{ $comment_category }}</div>
			</div>
			<div class="info-row">
				<div class="info-label">신고 사유</div>
				<div class="info-value">{{ $report_category[$report->report_code] }}</div>
			</div>
			<div class="info-row">
				<div class="info-label">처리 여부</div>
				<div class="info-value">
					@if($report->report_status === '01')
						<span class="status-badge status-pending">처리 대기</span>
					@else
						<span class="status-badge status-completed">처리 완료</span>
					@endif
				</div>
			</div>

			<div class="info-row detail-reason">
				<div class="info-label">댓글 내용</div>
				<div class="comment-content">
					<div class="comment-header">
						<span class="user-info">작성자: {{ $reported_content->user->nickname }}</span>
						<span class="comment-date">{{ $reported_content->created_at }}</span>
					</div>
					<div class="comment-text">
						{{ $reported_content->post_comment }}
					</div>
				</div>
			</div>

			<div class="info-row detail-reason">
				<div class="info-label">신고 상세사유</div>
				<div class="info-value">
					{{ $report->report_text }}
				</div>
			</div>
		</div>

		<div class="punishment-section">
			<h2 class="section-title">징계하기</h2>
			<form action="/manager/reports/comments/{{ $report->report_id }}" method="POST" >
				@csrf
				@if($report->report_status === '01')
				<div class="form-group">
					<label class="form-label">징계 여부</label>
					<select class="form-select" name="report_result" id="punishmentType" onchange="togglePunishmentFields()">
						<option value="01">혐의없음</option>
						<option value="02">정지</option>
						<option value="03">강제탈퇴</option>
					</select>
				</div>
				@else
				<div class="form-group">
					<label class="form-label">징계 여부</label>
					<select class="form-select" name="report_result" id="punishmentType" disabled>
						<option value="01">혐의없음</option>
						<option value="02">정지</option>
						<option value="03">강제탈퇴</option>
					</select>
				</div>
				@endif

				@if($report->report_status === '01')
				<div class="form-group" id="suspendDays">
					<label class="form-label">정지 기간 (일)</label>
					<input type="number" name="ban_at" class="form-input" min="1" max="365" disabled>
				</div>

				<div class="form-group" id="suspendReason">
					<label class="form-label">정지 사유</label>
					<textarea class="form-textarea" name="report_reason" placeholder="정지 사유를 입력하세요" ></textarea>
				</div>
				@else
				<div class="form-group" id="suspendDays">
					<label class="form-label">정지 기간 (일)</label>
					<input type="text" class="form-input" min="1" max="365" disabled value="{{ $report_result->ban_at ?? '' }}">
				</div>

				<div class="form-group" id="suspendReason">
					<label class="form-label">정지 사유</label>
					<textarea class="form-textarea" placeholder="정지 사유를 입력하세요" disabled>{{ $report_result->report_reason ?? '' }}</textarea>
				</div>
				@endif

				<div class="action-buttons">
					@if($report->report_status === '01')
					<button type="submit" class="btn btn-primary" >
						<i class="fas fa-gavel"></i>
						징계 처리하기
					</button>
					@endif
					<a href="/manager/reports/comments" class="btn btn-secondary">
						<i class="fas fa-list"></i>
						목록으로
					</a>
				</div>
			</form>
		</div>
	</div>
</div>
@if($errors->any())
<p>{{ $errors->first() }}</p>
@endif
@endsection

@section('scripts')
<script>
	function togglePunishmentFields() {
		const punishmentType = document.getElementById('punishmentType').value;
		const suspendDaysInput = document.querySelector('#suspendDays input');
		const suspendReasonTextarea = document.querySelector('#suspendReason textarea');
		
		if (punishmentType === '01' || punishmentType === '03') {
			suspendDaysInput.value = '';
			suspendDaysInput.disabled = true;

		} else {
			suspendDaysInput.disabled = false;
		}
	}
	function punishmentProcess(){
		if(confirm('징계 처리하시겠습니까?')){
			document.querySelector('form').submit();
		}
		return false;
	}

	// 페이지 로드 시 초기 상태 설정
	@if($report->report_status === '01')
	document.addEventListener('DOMContentLoaded', function() {
		togglePunishmentFields();
	});
	@endif

</script>
@endsection
