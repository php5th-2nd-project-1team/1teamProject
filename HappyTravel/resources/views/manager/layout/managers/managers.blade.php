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
                    @foreach($managers as $manager)
                    <tr class="clickable-row" data-href="/manager/managers/{{-- $manager->manager_id --}}#">
                        <td>{{ $manager->manager_id }}</td>
                        <td>{{ $manager->m_account }}</td>
                        <td>{{ $manager->m_nickname }}</td>
                        <td>
                            <span class="grade-admin">최고관리자</span>
                            {{-- <span class="grade-manager">일반관리자</span> --}}
                        </td>
                        <td>{{ mb_substr($manager->created_at, 0, 10) }}</td>
                        <td>
                            <span class="status-badge status-active">활성</span>
                            {{-- <span class="status-badge status-inactive">비활성</span> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            
            <nav aria-label="Page navigation" class="w-100">
                <ul class="pagination">
                    @if(!$managers->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$managers->url(1)}}" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @endif
                    @php
                        $currentPage = $managers->currentPage();
                        $lastPage = $managers->lastPage();
                        
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
                            <a class="page-link" href="{{ $managers->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if(!$managers->onLastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$managers->url($managers->lastPage())}}" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    @endif
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
