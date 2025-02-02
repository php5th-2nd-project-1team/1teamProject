@extends('manager.base')

@section('additional_css')
<style>
    .users-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .users-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .users-container {
        padding: 0 15px;
    }
    .users-table-section {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .clickable-row:hover {
        background-color: #f5f5f5 !important;
    }
</style>
@endsection

@section('content')
<div class="users-header">
    <div class="container-fluid">
        <h1 class="users-title">유저 관리</h1>
    </div>
</div>
<div class="users-container">
    <div class="users-table-section">
        <div class="table-responsive">
            {{-- Bootstrap의 table-striped는 테이블 행들 번갈아가면서 다른 배경색 넣어주는거임 --}}
            {{-- 테이블 읽기 쉽게 만들어주고 행 구분하기 편하게 해줌 --}}
            {{-- 보통 짝수 행은 연한 회색, 홀수 행은 흰색으로 나옴 --}}   
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>계정</th>
                        <th>이름</th>
                        <th>닉네임</th>
                        <th>성별</th>
                        <th>전화번호</th>
                        <th>이메일</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="clickable-row" data-href="/manager/users/{{ $user->user_id }}?page={{ $users->currentPage() }}">
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->account }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nickname }}</td>
                        <td>{{ $user->gender === '0' ? '남성' : '여성' }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if(!$users->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{$users->url(1)}}" aria-label="First">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @endif
                @php
                    $currentPage = $users->currentPage();
                    $lastPage = $users->lastPage();
                    
                    // 시작 페이지와 끝 페이지 계산

                    // max() 함수는 주어진 두 값 중 더 큰 값을 반환할 것
                    // 현재 페이지에서 2를 뺀 값과 1 중에서 큰 값을 선택하여 시작 페이지가 1보다 작아지지 않도록 함
                    $startPage = max($currentPage - 2, 1);
                    
                    // min() 함수는 주어진 두 값 중 더 작은 값을 반환할 것
                    // 시작 페이지에 4를 더한 값과 마지막 페이지 중에서 작은 값을 선택하여 끝 페이지가 마지막 페이지를 넘지 않도록 함
                    $endPage = min($startPage + 4, $lastPage);
                    
                    // 시작 페이지 재조정 (끝 페이지가 마지막 페이지보다 작을 경우)
                    if ($endPage - $startPage < 4) {
                        $startPage = max($endPage - 4, 1);
                    }
                @endphp
                @for ($i = $startPage; $i <= $endPage; $i++)
                    <li class="page-item {{ $i === $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                @if(!$users->onLastPage())
                <li class="page-item">
                    <a class="page-link" href="{{$users->url($users->lastPage())}}" aria-label="Last">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
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
