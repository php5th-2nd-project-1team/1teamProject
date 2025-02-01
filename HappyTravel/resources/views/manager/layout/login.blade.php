@extends('manager.base')

@section('title', '관리자 로그인')

@section('additional_css')
<style>
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
    }
    .login-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="login-container">
        <h2 class="login-title">관리자 로그인</h2>
        
        <form method="POST" action="#">
            @csrf
            <div class="form-group">
                <label for="account">아이디</label>
                <input type="text" class="form-control" id="account" name="account" required>
            </div>
            
            <div class="form-group">
                <label for="password">비밀번호</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">로그인</button>
        </form>
    </div>
</div>
@endsection
