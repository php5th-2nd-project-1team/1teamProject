@extends('manager.base')

@section('additional_css')
<style>
    .inquiries-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .inquiries-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .inquiries-container {
        padding: 0 15px;
    }
    .inquiries-table-section {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .clickable-row:hover {
        background-color: #f5f5f5 !important;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .status-pending {
        background-color: #ffeeba;
        color: #856404;
    }
    .status-completed {
        background-color: #c3e6cb;
        color: #155724;
    }
    .pagination-container {
        margin-top: 30px;
    }
    .pagination {
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="inquiries-header">
    <div class="container-fluid">
        <h1 class="inquiries-title">문의 관리</h1>
    </div>
</div>

<div class="inquiries-container">
    <div class="inquiries-table-section">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>글 번호</th>
                        <th>유저 번호</th>
                        <th>문의 제목</th>
                        <th>작성일자</th>
                        <th>답변 여부</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                    <tr class="clickable-row" data-href="/manager/inquiries/{{ $inquiry->inquiry_id }}">
                        <td>{{ $inquiry->inquiry_id }}</td>
                        <td>{{ $inquiry->users->user_id }}</td>
                        <td>{{ $inquiry->inquiry_title }}</td>
                        <td>{{ $inquiry->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($inquiry->inquiry_response)
                                <span class="status-badge status-completed">답변 완료</span>
                            @else
                                <span class="status-badge status-pending">답변 대기</span>
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
                    @if(!$inquiries->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$inquiries->url(1)}}" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @endif
                    @php
                        $currentPage = $inquiries->currentPage();
                        $lastPage = $inquiries->lastPage();
                        
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
                            <a class="page-link" href="{{ $inquiries->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if(!$inquiries->onLastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$inquiries->url($inquiries->lastPage())}}" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
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
