@extends('manager.base')

@section('additional_css')
<style>
    .shops-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .shops-title-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .shops-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .shops-container {
        padding: 0 15px;
    }
    .shops-table-section {
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
    .status-active {
        background-color: #c3e6cb;
        color: #155724;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }
    .pagination-container {
        margin-top: 30px;
        position: relative;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin: 0;
    }
    .create-btn {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        padding: 8px 20px;
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .create-btn:hover {
        background-color: #2980b9;
        color: white;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="shops-header">
    <div class="container-fluid">
        <h1 class="shops-title">클래스 관리</h1>
    </div>
</div>

<div class="shops-container">
    <div class="shops-table-section">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>클래스 이름</th>
                        <th>가격</th>
                        <th>지역</th>
                        <th>진행 여부</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shops as $shop)
                    <tr class="clickable-row" data-href="/manager/shops/{{$shop->class_id}}">
                        <td>{{$shop->class_id}}</td>
                        <td>{{$shop->class_title}}</td>
                        <td>{{number_format($shop->class_price)}}원</td>
                        <td>{{$shop->location}}</td>
                        <td>
                            <span class="status-badge status-active">진행중</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if(!$shops->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$shops->url(1)}}" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @endif
                    @php
                        $currentPage = $shops->currentPage();
                        $lastPage = $shops->lastPage();
                        
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
                            <a class="page-link" href="{{ $shops->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if(!$shops->onLastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{$shops->url($shops->lastPage())}}" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <a href="/manager/shops/create" class="create-btn">
                <i class="fas fa-plus"></i>
                클래스 등록
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
