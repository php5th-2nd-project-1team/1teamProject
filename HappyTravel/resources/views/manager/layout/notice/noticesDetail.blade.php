@extends('manager.base')

@section('additional_css')
<style>
    .notice-detail-header {
        background-color: #f8f9fa;
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .notice-detail-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .notice-detail-container {
        padding: 0 15px;
    }
    .notice-detail-section {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .notice-info {
        display: flex;
        gap: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
        margin-bottom: 30px;
        color: #666;
    }
    .notice-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .notice-content {
        min-height: 200px;
        line-height: 1.8;
        color: #2c3e50;
        white-space: pre-line;
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
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        color: white;
    }
    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
        color: white;
    }
    .btn-secondary {
        background-color: #95a5a6;
        border-color: #95a5a6;
        color: white;
    }
    .btn:hover {
        opacity: 0.9;
        color: white;
        text-decoration: none;
    }
    .notice-link {
        display: inline-block;
        color: #3498db;
        text-decoration: none;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }
    .notice-link:hover {
        text-decoration: underline;
        color: #2980b9;
    }
    .notice-link i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="notice-detail-header">
    <div class="container-fluid">
        <h1 class="notice-detail-title">공지사항 상세</h1>
    </div>
</div>

<div class="notice-detail-container">
    <div class="notice-detail-section">
        <a href="/community/notice/{{ $notice->notice_id }}" target="_blank" class="notice-link">
            <i class="fas fa-external-link-alt"></i>
            사용자 페이지에서 보기
        </a>

        <h2>{{ $notice->notice_title }}</h2>
        
        <div class="notice-info">
            <div class="notice-info-item">
                <i class="fas fa-hashtag"></i>
                <span>id. {{ $notice->notice_id }}</span>
            </div>
            <div class="notice-info-item">
                <i class="fas fa-user"></i>
                <span>{{ $notice->managers->m_nickname }}</span>
            </div>
            <div class="notice-info-item">
                <i class="fas fa-calendar"></i>
                <span>{{ $notice->created_at }}</span>
            </div>
        </div>

        <div class="notice-content">
            {!! $notice->notice_content !!}
        </div>

        <div class="action-buttons">
            <button type="button" class="btn btn-primary" onclick="handleEdit()">
                <i class="fas fa-edit"></i>
                수정
            </button>
            <button type="button" class="btn btn-danger" onclick="handleDelete()">
                <i class="fas fa-trash-alt"></i>
                삭제
            </button>
            <a href="/manager/notices?page={{ $page }}" class="btn btn-secondary">
                <i class="fas fa-list"></i>
                목록
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleEdit() {
        if(confirm('공지사항을 수정하시겠습니까?')) {
            window.location.href = '/manager/notices/edit/{{ $notice->notice_id }}';
        }
    }
    
    function handleDelete() {
        if(confirm('정말로 이 공지사항을 삭제하시겠습니까?')) {
            // TODO: 삭제 처리
            console.log('삭제 처리가 진행됩니다.');
        }
    }
</script>
@endsection
