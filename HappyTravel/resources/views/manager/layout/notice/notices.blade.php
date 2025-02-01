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
                    @for ($i = 1; $i <= 10; $i++)
                    <tr class="clickable-row" data-href="/manager/notices/{{ $i }}">
                        <td>{{ $i }}</td>
                        <td>공지사항 제목 {{ $i }}</td>
                        <td>관리자</td>
                        <td>2024-02-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            @if($i % 3 == 0)
                                <span class="text-danger">중요</span>
                            @else
                                <span class="text-muted">일반</span>
                            @endif
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
