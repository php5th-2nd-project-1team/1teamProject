@extends('manager.base')

@section('additional_css')
<style>
    .reports-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .reports-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .reports-container {
        padding: 0 15px;
    }
    .reports-table-section {
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
    .content-cell {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
        margin-top: 0;
    }
</style>
@endsection

@section('content')
<div class="reports-header">
    <div class="container-fluid">
        <h1 class="reports-title">댓글 신고 관리</h1>
    </div>
</div>

<div class="reports-container">
    <div class="reports-table-section">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>신고자</th>
                        <th>신고사유</th>
                        <th>내용</th>
                        <th>처리 여부</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr class="clickable-row" data-href="/manager/reports/comments/{{ $report->report_id }}">
                        <td>{{ $report->report_id }}</td>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $category[$report->report_code]}}</td>
                        <td class="content-cell">
                            {{ $report->report_text }}
                        </td>
                        <td>
                            @if($report->report_status === '01')
                                <span class="status-badge status-pending">처리 대기</span>
                            @else
                                <span class="status-badge status-completed">처리 완료</span>
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
                    @if(!$reports->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$reports->url(1)}}" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @endif
                    @php
                        $currentPage = $reports->currentPage();
                        $lastPage = $reports->lastPage();
                        
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
                            <a class="page-link" href="{{ $reports->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if(!$reports->onLastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$reports->url($reports->lastPage())}}" aria-label="Last">
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
