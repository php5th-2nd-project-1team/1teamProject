@extends('manager.base')

@section('additional_css')
<style>
	.manager-create-header {
		background-color: #f8f9fa;
		padding: 25px 0;
		margin-bottom: 30px;
		border-bottom: 1px solid #dee2e6;
		box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	}
	.manager-create-title {
		font-size: 2rem;
		font-weight: bold;
		color: #2c3e50;
		margin: 0;
	}
	.manager-create-container {
		padding: 0 15px;
	}
	.manager-create-section {
		background-color: white;
		padding: 40px;
		border-radius: 12px;
		box-shadow: 0 2px 15px rgba(0,0,0,0.1);
		margin-bottom: 30px;
	}
	.manager-form {
		border: 1px solid #dee2e6;
		padding: 15px;
		border-radius: 8px;
		margin-bottom: 15px;
		position: relative;
	}
	.form-group {
		margin-bottom: 12px;
	}
	.form-label {
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 4px;
		display: block;
		font-size: 0.9rem;
	}
	.form-control {
		width: 100%;
		padding: 8px;
		border: 1px solid #ced4da;
		border-radius: 6px;
		font-size: 0.9rem;
	}
	.remove-form {
		position: absolute;
		top: 5px;
		right: 5px;
		background: #e74c3c;
		color: white;
		border: none;
		width: 24px;
		height: 24px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
	}
	.add-manager-btn {
		width: 100%;
		padding: 12px;
		background-color: #3498db;
		color: white;
		border: 2px dashed #2980b9;
		border-radius: 8px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		font-size: 1rem;
		margin-bottom: 20px;
	}
	.add-manager-btn:hover {
		background-color: #2980b9;
	}
	.action-buttons {
		margin-top: 40px;
		padding-top: 20px;
		border-top: 1px solid #dee2e6;
		display: flex;
		gap: 15px;
	}
	.btn {
		padding: 12px 25px;
		border-radius: 8px;
		font-weight: 500;
		display: flex;
		align-items: center;
		gap: 8px;
		cursor: pointer;
		font-size: 1rem;
	}
	.btn-primary {
		background-color: #2ecc71;
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
	.info-group {
		margin-bottom: 12px;
	}
	.info-value {
		color: #495057;
		font-size: 0.9rem;
		padding: 8px;
	}
	.add-manager-btn:hover {
		background-color: #2980b9;
	}
</style>
@endsection

@section('content')
<div class="manager-create-header">
	<div class="container-fluid">
		<h1 class="manager-create-title">관리자 추가</h1>
	</div>
</div>

<div class="manager-create-container">
	<div class="manager-create-section">
		<form id="managersForm" method="POST" action="/manager/managers" onsubmit="return handleSubmit(event)" id="managersForm">
			@csrf
			<div id="managerForms">
				<!-- 초기 폼 -->
				<div class="manager-form">
					<button type="button" class="remove-form" onclick="removeForm(this)">×</button>
					<div class="form-group">
						<label class="form-label">계정</label>
						<input type="text" class="form-control" name="managers[0][m_account]" placeholder="이메일을 입력하세요" required>
					</div>
					<div class="form-group">
						<label class="form-label">비밀번호</label>
						<input type="password" class="form-control" name="managers[0][m_password]" placeholder="비밀번호를 입력하세요" required>
					</div>
					<div class="form-group">
						<label class="form-label">닉네임</label>
						<input type="text" class="form-control" name="managers[0][m_nickname]" placeholder="닉네임을 입력하세요" required>
					</div>
				</div>
			</div>

			<button type="button" class="add-manager-btn" onclick="addManagerForm()">
				<i class="fas fa-plus"></i>
				관리자 추가
			</button>

			<div class="action-buttons">
				<button type="submit" class="btn btn-primary">
					<i class="fas fa-user-plus"></i>
					관리자 등록
				</button>
				<a href="/manager/managers" class="btn btn-secondary">
					<i class="fas fa-times"></i>
					취소
				</a>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scripts')
<script>
	let formCount = 1;

	function addManagerForm() {
		const template = `
			<div class="manager-form">
				<button type="button" class="remove-form" onclick="removeForm(this)">×</button>
				<div class="form-group">
					<label class="form-label">계정</label>
					<input type="text" class="form-control" name="managers[${formCount}][m_account]" placeholder="이메일을 입력하세요" required>
				</div>
				<div class="form-group">
					<label class="form-label">비밀번호</label>
					<input type="password" class="form-control" name="managers[${formCount}][m_password]" placeholder="비밀번호를 입력하세요" required>
				</div>
				<div class="form-group">
					<label class="form-label">닉네임</label>
					<input type="text" class="form-control" name="managers[${formCount}][m_nickname]" placeholder="닉네임을 입력하세요" required>
				</div>
			</div>
		`;
		
		document.getElementById('managerForms').insertAdjacentHTML('beforeend', template);
		formCount++;
	}

	function removeForm(button) {
		const form = button.closest('.manager-form');
		if (document.querySelectorAll('.manager-form').length > 1) {
			form.remove();
		} else {
			alert('최소 한 개의 폼이 필요합니다.');
		}
	}

	function handleSubmit(event) {
		event.preventDefault();
		
		if(confirm('입력한 관리자들을 등록하시겠습니까?')) {
			// const formData = new FormData(event.target);
			event.target.submit();
		}
		return false;
	}
</script>
@endsection
