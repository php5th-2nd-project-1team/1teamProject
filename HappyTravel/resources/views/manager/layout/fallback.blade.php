@extends('manager.base')

@section('additional_css')
<style>
    .fallback-container {
        text-align: center;
        padding: 60px 20px;
    }
    .fallback-message {
        font-size: 1.5rem;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    .home-link {
        color: #007bff;
        text-decoration: none;
        font-size: 1.1rem;
    }
    .home-link:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="fallback-container">
    <div class="fallback-message">
        해당 페이지는 존재하지 않는 페이지입니다.
    </div>
    <a href="{{ route('manager.index') }}" class="home-link">
        메인 페이지로 돌아가기 →
    </a>
</div>
@endsection
