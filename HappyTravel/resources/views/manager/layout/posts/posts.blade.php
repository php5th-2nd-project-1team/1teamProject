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
                    @foreach ($posts as $post)
                    <tr class="clickable-row" data-href="/manager/posts/{{ $post->post_id }}?page={{ $posts->currentPage() }}">
                        <td>{{ $post->post_id }}</td>
                        <td>{{ $post->post_title }}</td>
                        <td>{{ $post->post_local_name }}</td>
                        <td class="content-preview">{{ $post->post_content }}</td>
                        <td><i class="fas fa-eye stats-icon"></i>{{ $post->post_view }}</td>
                        <td><i class="fas fa-heart stats-icon"></i>{{ $post->post_likes_count }}</td>
                        <td>
                            {{-- <span class="status-badge {{ ['status-active', 'status-pending', 'status-inactive'][$i % 3] }}">
                                {{ ['활성', '대기', '비활성'][$i % 3] }}
                            </span> --}}
                            <span class="status-badge status-active">
                                활성
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if(!$posts->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$posts->url(1)}}" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @endif
                    @php
                        $currentPage = $posts->currentPage();
                        $lastPage = $posts->lastPage();
                        
                        // 시작 페이지와 끝 페이지 계산
                        $startPage = max($currentPage - 2, 1);
                        $endPage = min($startPage + 4, $lastPage);
                        
                        // 시작 페이지 재조정
                        if ($endPage - $startPage < 4) {
                            $startPage = max($endPage - 4, 1);
                        }
                    @endphp
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i === $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if(!$posts->onLastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$posts->url($posts->lastPage())}}" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    @endif
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
