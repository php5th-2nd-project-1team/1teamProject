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
                        <th>피신고자</th>
                        <th>신고사유</th>
                        <th>내용</th>
                        <th>처리 여부</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="clickable-row">
                        <td>1</td>
                        <td>사용자1</td>
                        <td>부적절한 내용</td>
                        <td class="content-cell">
                            이것은 신고된 댓글의 내용입니다...
                        </td>
                        <td>
                            <span class="status-badge status-pending">처리 대기</span>
                        </td>
                    </tr>
                    <tr class="clickable-row">
                        <td>2</td>
                        <td>사용자2</td>
                        <td>스팸</td>
                        <td class="content-cell">
                            광고성 댓글 내용입니다...
                        </td>
                        <td>
                            <span class="status-badge status-completed">처리 완료</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
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
                // 클릭 이벤트 처리
                console.log('Row clicked');
            });
        });
    });
</script>
@endsection
