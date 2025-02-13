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
                    <tr class="clickable-row" data-href="/manager/inquiries/1">
                        <td>1</td>
                        <td>user123</td>
                        <td>결제 관련 문의드립니다.</td>
                        <td>2024-01-15</td>
                        <td>
                            <span class="status-badge status-pending">답변 대기</span>
                        </td>
                    </tr>
                    <tr class="clickable-row" data-href="/manager/inquiries/2">
                        <td>2</td>
                        <td>user456</td>
                        <td>클래스 환불 문의</td>
                        <td>2024-01-14</td>
                        <td>
                            <span class="status-badge status-completed">답변 완료</span>
                        </td>
                    </tr>
                    <tr class="clickable-row" data-href="/manager/inquiries/3">
                        <td>3</td>
                        <td>user789</td>
                        <td>예약 변경 가능한가요?</td>
                        <td>2024-01-14</td>
                        <td>
                            <span class="status-badge status-pending">답변 대기</span>
                        </td>
                    </tr>
                    <tr class="clickable-row" data-href="/manager/inquiries/4">
                        <td>4</td>
                        <td>user101</td>
                        <td>클래스 일정 문의</td>
                        <td>2024-01-13</td>
                        <td>
                            <span class="status-badge status-completed">답변 완료</span>
                        </td>
                    </tr>
                    <tr class="clickable-row" data-href="/manager/inquiries/5">
                        <td>5</td>
                        <td>user202</td>
                        <td>포인트 적립 관련 문의</td>
                        <td>2024-01-13</td>
                        <td>
                            <span class="status-badge status-completed">답변 완료</span>
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
                window.location.href = this.dataset.href;
            });
        });
    });
</script>
@endsection
