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
                    @for ($i = 1; $i <= 10; $i++)
                    <tr class="clickable-row" data-href="/manager/users/{{ $i }}">
                        <td>{{ $i }}</td>
                        <td>user{{ $i }}</td>
                        <td>홍길동{{ $i }}</td>
                        <td>길동이{{ $i }}</td>
                        <td>{{ $i % 2 == 0 ? '여성' : '남성' }}</td>
                        <td>010-1234-{{ sprintf('%04d', $i) }}</td>
                        <td>user{{ $i }}@example.com</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
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
