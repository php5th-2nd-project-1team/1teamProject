@extends('manager.base')

@section('additional_css')
<style>
    .notices-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .notices-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .notices-container {
        padding: 0 15px;
    }
    .notices-table-section {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .important-badge {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .clickable-row:hover {
        background-color: #f5f5f5 !important;
    }
    .pagination-container {
        position: relative;
        margin-top: 30px;
    }
    .pagination {
        margin-top: 0;
        justify-content: center;
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
<div class="notices-header">
    <div class="container-fluid">
        <h1 class="notices-title">공지사항 관리</h1>
    </div>
</div>

<div class="notices-container">
    <div class="notices-table-section">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>작성일자</th>
                        <th>중요 여부</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notices as $notice)
                    <tr class="clickable-row" data-href="/manager/notices/{{ $notice->notice_id }}?page={{ $page }}">
                        <td>{{ $notice->notice_id }}</td>
                        <td>{{ $notice->notice_title }}</td>
                        <td>{{ $notice->managers->m_nickname }}</td>
                        <td>{{ $notice->created_at }}</td>
                        <td>
                            @if($notice->notice_tag === '0')
                                <span class="text-danger">일반</span>
                            @else
                                <span class="text-muted">중요</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if(!$notices->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$notices->url(1)}}" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @endif
                    @php
                        $currentPage = $notices->currentPage();
                        $lastPage = $notices->lastPage();
                        
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
                            <a class="page-link" href="{{ $notices->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if(!$notices->onLastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$notices->url($notices->lastPage())}}" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <a href="/manager/notices/create" class="create-button">
                <i class="fas fa-plus"></i>
                공지사항 작성
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
