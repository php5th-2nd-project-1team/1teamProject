@extends('manager.base')

@section('additional_css')
<style>
    .shop-detail-header {
        background-color: #f8f9fa;
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .shop-detail-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .shop-detail-container {
        padding: 0 15px;
    }
    .shop-detail-section {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .info-group {
        margin-bottom: 30px;
    }
    .info-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
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
    .class-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    .class-content {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
        line-height: 1.6;
    }
    .action-buttons {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 2px solid #eee;
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
        border: none;
        color: white;
    }
    .btn-danger {
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
        color: white;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="shop-detail-header">
    <div class="container-fluid">
        <h1 class="shop-detail-title">클래스 상세 정보</h1>
    </div>
</div>

<div class="shop-detail-container">
    <div class="shop-detail-section">
        <div class="info-group">
            <div class="info-row">
                <div class="info-label">해당 페이지로</div>
                <div class="info-value">
                    <a href="{{ $url }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-external-link-alt mr-1"></i>
                        새 탭에서 열기
                    </a>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">클래스 ID</div>
                <div class="info-value">{{ $travelClass->class_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">클래스 이름</div>
                <div class="info-value">{{ $travelClass->class_title }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">대표 이미지</div>
                <div class="info-value">
                    <img src="{{ $travelClass->class_title_img }}" alt="클래스 이미지" class="class-image">
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">클래스 가격</div>
                <div class="info-value">{{ $travelClass->class_price }}원</div>
            </div>
            <div class="info-row">
                <div class="info-label">클래스 위치</div>
                <div class="info-value">{{ $travelClass->location }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">시행 시간</div>
                <div class="info-value">{{ $travelClass->class_date }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">클래스 내용</div>
                <div class="info-value">
                    <div class="class-content">
                            {!! $travelClass->class_content ?? '<p>강아지와 함께 즐기는 베이킹 클래스입니다.<br>
                            반려견과 함께 건강한 간식을 만들어보세요.</p>' !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <form action="/manager/shops/destroy/1" method="POST" style="display: inline;" onsubmit="return confirm('정말로 이 클래스를 삭제하시겠습니까?');">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    클래스 삭제
                </button>
            </form>
            <a href="{{ $url }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                페이지로 이동
            </a>
            <a href="/manager/shops" class="btn btn-secondary">
                <i class="fas fa-list"></i>
                목록으로
            </a>
        </div>
    </div>
</div>
@endsection
