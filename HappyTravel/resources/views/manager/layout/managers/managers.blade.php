@extends('manager.base')

@section('additional_css')
<style>
    .managers-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .managers-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .managers-container {
        padding: 0 15px;
    }
    .managers-table-section {
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
    .grade-admin {
        color: #e74c3c;
        font-weight: 600;
    }
    .grade-manager {
        color: #3498db;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="managers-header">
    <div class="container-fluid">
        <h1 class="managers-title">관리자 관리</h1>
    </div>
</div>

<div class="managers-container">
    <div class="managers-table-section">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>계정</th>
                        <th>닉네임</th>
                        <th>등급</th>
                        <th>생성 일자</th>
                        <th>계정 상태</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr class="clickable-row" data-href="/manager/managers/{{ $i }}">
                        <td>{{ $i }}</td>
                        <td>admin{{ $i }}@example.com</td>
                        <td>관리자{{ $i }}</td>
                        <td>
                            @if($i % 3 == 0)
                                <span class="grade-admin">최고관리자</span>
                            @else
                                <span class="grade-manager">일반관리자</span>
                            @endif
                        </td>
                        <td>2024-02-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            @if($i % 4 != 0)
                                <span class="status-badge status-active">활성</span>
                            @else
                                <span class="status-badge status-inactive">비활성</span>
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
            <a href="/manager/managers/create" class="create-button">
                <i class="fas fa-plus"></i>
                관리자 추가
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
