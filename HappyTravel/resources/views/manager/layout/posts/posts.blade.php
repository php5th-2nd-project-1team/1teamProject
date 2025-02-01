@extends('manager.base')

@section('additional_css')
<style>
    .posts-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .posts-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .posts-container {
        padding: 0 15px;
    }
    .posts-table-section {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-active {
        background-color: #28a745;
        color: white;
    }
    .status-inactive {
        background-color: #dc3545;
        color: white;
    }
    .status-pending {
        background-color: #ffc107;
        color: black;
    }
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .clickable-row:hover {
        background-color: #f5f5f5 !important;
    }
    .pagination {
        margin-top: 30px;
        justify-content: center;
    }
    .page-link {
        color: #2c3e50;
        padding: 8px 16px;
    }
    .page-item.active .page-link {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
    .content-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .stats-icon {
        color: #6c757d;
        margin-right: 5px;
    }
    .pagination-container {
        position: relative;
        margin-top: 30px;
    }
    
    .create-button {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .create-button:hover {
        background-color: #2980b9;
        color: white;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="posts-header">
    <div class="container-fluid">
        <h1 class="posts-title">포스트 관리</h1>
    </div>
</div>

<div class="posts-container">
    <div class="posts-table-section">
        <div class="table-responsive">
			{{-- Bootstrap의 table-striped는 테이블 행들 번갈아가면서 다른 배경색 넣어주는거임 --}}
			{{-- 테이블 읽기 쉽게 만들어주고 행 구분하기 편하게 해줌 --}}
			{{-- 보통 짝수 행은 연한 회색, 홀수 행은 흰색으로 나옴 --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>제목</th>
                        <th>지역</th>
                        <th>콘텐츠</th>
                        <th>조회수</th>
                        <th>좋아요</th>
                        <th>상태</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr class="clickable-row" data-href="/manager/posts/{{ $i }}">
                        <td>{{ $i }}</td>
                        <td>맛있는 식당 {{ $i }}</td>
                        <td>{{ ['서울', '부산', '대구', '인천', '광주'][$i % 5] }}</td>
                        <td class="content-preview">이 식당은 정말 맛있습니다. 특히 김치찌개가 일품입니다...</td>
                        <td><i class="fas fa-eye stats-icon"></i>{{ $i * 123 }}</td>
                        <td><i class="fas fa-heart stats-icon"></i>{{ $i * 45 }}</td>
                        <td>
                            <span class="status-badge {{ ['status-active', 'status-pending', 'status-inactive'][$i % 3] }}">
                                {{ ['활성', '대기', '비활성'][$i % 3] }}
                            </span>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <nav aria-label="Page navigation" class="w-100">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item active"><a class="page-link" href="#">5</a></li>
                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <a href="/manager/posts/create" class="create-button">
                <i class="fas fa-plus"></i>
                포스트 작성
            </a>
        </div>
    </div>
</div>
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
