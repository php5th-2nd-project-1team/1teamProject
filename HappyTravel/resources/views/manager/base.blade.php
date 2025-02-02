<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', '관리자 페이지')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* 전체 컨테이너 높이 설정 */
        html, body {
            height: 100%;
            margin: 0;
        }
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
            display: flex;  /* Flexbox 사용 */
        }
        .row {
            margin-left: 0;
            margin-right: 0;
            flex: 1;  /* 남은 공간 모두 차지 */
            display: flex;  /* Nested Flexbox */
        }
        /* 사이드바 컨테이너 */
        .sidebar-container {
            padding-left: 0;
            padding-right: 0;
            background-color: #2c3e50;
            min-height: 100vh;
            flex-shrink: 0;  /* 사이드바 크기 고정 */
        }
        /* 사이드바 스타일 */
        .sidebar {
            height: 100%;
            color: white;
            padding-top: 20px;
            width: 100%;
        }
        /* 메인 콘텐츠 영역 */
        .main-content {
            padding: 20px;
            flex: 1;  /* 남은 공간 모두 차지 */
            overflow-y: auto;  /* 필요시 스크롤 */
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 25%;  /* col-md-3의 너비에 해당 */
            }
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 10px 20px;
        }
        .sidebar .nav-link:hover {
            background-color: #34495e;
        }
        .sidebar .submenu {
            padding-left: 30px;
            background-color: #34495e;
        }
        .logo {
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
        }
        .menu-header {
            font-weight: bold;
            padding: 10px 20px;
            border-top: 1px solid #3d566e;
            cursor: pointer;
            text-decoration: none;
            color: white;
            display: block;
        }
        .menu-header:hover {
            background-color: #34495e;
            color: white;
            text-decoration: none;
        }
    </style>
    @yield('additional_css')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar-container">
                @include('manager.layout.sidebar')
            </div>
            <div class="col-md-9 col-lg-10 main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @yield('scripts')
</body>
</html>

