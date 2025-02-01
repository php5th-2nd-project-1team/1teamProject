@extends('manager.base')

@section('additional_css')
<style>
    .user-detail-header {
        background-color: #f8f9fa;
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .user-detail-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .user-status {
        font-size: 0.9rem;
        padding: 5px 12px;
        border-radius: 20px;
        background-color: #28a745;
        color: white;
    }
    .user-status.inactive {
        background-color: #dc3545;
    }
    .user-status.suspended {
        background-color: #ffc107;
        color: #000;
    }
    .user-detail-container {
        padding: 0 15px;
    }
    .user-detail-section {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    .user-profile-section {
        display: flex;
        gap: 30px;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eee;
    }
    .profile-image-container {
        flex-shrink: 0;
    }
    .profile-info {
        flex-grow: 1;
    }
    .profile-image {
        max-width: 200px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .info-group {
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    .info-group:hover {
        transform: translateX(5px);
    }
    .info-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        color: #495057;
        font-size: 1.1rem;
        padding: 8px 0;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .info-group:hover .info-value {
        border-bottom-color: #3498db;
    }
    .address-group {
        margin-left: 20px;
        margin-top: 10px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    .action-buttons {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
        display: flex;
        gap: 15px;
    }
    .btn {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn i {
        font-size: 1.1rem;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .user-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        flex: 1;
        text-align: center;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="user-detail-header">
    <div class="container-fluid">
        <h1 class="user-detail-title">
            유저 상세 정보
            <span class="user-status">활성 계정</span>
        </h1>
    </div>
</div>

<div class="user-detail-container">
    <div class="user-detail-section">
        <div class="user-stats">
            <div class="stat-card">
                <div class="stat-value">42</div>
                <div class="stat-label">게시글</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">128</div>
                <div class="stat-label">댓글</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">2024.01.15</div>
                <div class="stat-label">가입일</div>
            </div>
        </div>

        <div class="user-profile-section">
            <div class="profile-image-container">
                <div class="info-label">프로필 사진</div>
                <img src="https://via.placeholder.com/200" alt="프로필 사진" class="profile-image">
            </div>
            
            <div class="profile-info">
                <div class="info-group">
                    <div class="info-label">유저 번호</div>
                    <div class="info-value">1</div>
                </div>

                <div class="info-group">
                    <div class="info-label">계정</div>
                    <div class="info-value">user123</div>
                </div>

                <div class="info-group">
                    <div class="info-label">이름</div>
                    <div class="info-value">홍길동</div>
                </div>
            </div>
        </div>

        <div class="info-group">
            <div class="info-label">닉네임</div>
            <div class="info-value">길동이</div>
        </div>

        <div class="info-group">
            <div class="info-label">성별</div>
            <div class="info-value">남성</div>
        </div>

        <div class="info-group">
            <div class="info-label">주소</div>
            <div class="address-group">
                <div class="info-group">
                    <div class="info-label">주소</div>
                    <div class="info-value">서울특별시 강남구 테헤란로</div>
                </div>
                <div class="info-group">
                    <div class="info-label">상세주소</div>
                    <div class="info-value">123번길 45, 67동 89호</div>
                </div>
                <div class="info-group">
                    <div class="info-label">우편번호</div>
                    <div class="info-value">06234</div>
                </div>
            </div>
        </div>

        <div class="info-group">
            <div class="info-label">전화번호</div>
            <div class="info-value">010-1234-5678</div>
        </div>

        <div class="info-group">
            <div class="info-label">이메일</div>
            <div class="info-value">hong@example.com</div>
        </div>

        <div class="action-buttons">
            <button type="button" class="btn btn-danger" onclick="confirmAction('탈퇴')">
                <i class="fas fa-user-times"></i>
                탈퇴 처리
            </button>
            <button type="button" class="btn btn-warning" onclick="confirmAction('징계')">
                <i class="fas fa-ban"></i>
                징계 처리
            </button>
            <button type="button" class="btn btn-success" onclick="confirmAction('징계해제')">
                <i class="fas fa-user-check"></i>
                징계 해제 처리
            </button>
            <button type="button" class="btn btn-secondary" onclick="confirmAction('비밀번호초기화')">
                <i class="fas fa-key"></i>
                비밀번호 초기화
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmAction(action) {
        let message = '';
        switch(action) {
            case '탈퇴':
                message = '해당 유저를 탈퇴 처리하시겠습니까?';
                break;
            case '징계':
                message = '해당 유저를 징계 처리하시겠습니까?';
                break;
            case '징계해제':
                message = '해당 유저의 징계를 해제하시겠습니까?';
                break;
            case '비밀번호초기화':
                message = '해당 유저의 비밀번호를 초기화하시겠습니까?';
                break;
        }
        
        if(confirm(message)) {
            // TODO: 각 액션에 대한 처리
            console.log(action + ' 처리가 진행됩니다.');
        }
    }
</script>
@endsection
