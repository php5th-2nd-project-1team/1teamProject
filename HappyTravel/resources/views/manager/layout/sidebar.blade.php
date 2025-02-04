<div class="sidebar">
	<div class="logo">
		<img src="/developImg/petbreeze_logo.png" alt="로고">
	</div>
	
	<div class="nav flex-column">
		<a href="#" class="menu-header">
			<i class="fas fa-users"></i> 유저
		</a>
		<span class="nav-link submenu disabled">신고</span>
		<a href="/manager/reports/comments" class="nav-link sub-submenu">- 댓글 신고</a>
		<a href="#" class="nav-link sub-submenu">- 게시글 신고</a>
		<a href="#" class="nav-link submenu">징계</a>

		<a href="#" class="menu-header">
			<i class="fas fa-user-shield"></i> 관리자
		</a>
		<a href="#" class="nav-link submenu">관리자 생성</a>

		<a href="#" class="menu-header">
			<i class="fas fa-file-alt"></i> 포스트
		</a>
		<a href="#" class="nav-link submenu">포스트 작성</a>

		<a href="#" class="menu-header">
			<i class="fas fa-bullhorn"></i> 공지사항
		</a>
		<a href="#" class="nav-link submenu">공지사항 작성</a>

		<a href="#" class="menu-header">
			<i class="fas fa-question-circle"></i> 문의사항
		</a>
		<a href="#" class="nav-link submenu">문의사항 작성</a>

		<a href="#" class="menu-header">
			<i class="fas fa-shopping-cart"></i> 상품
		</a>
		<a href="#" class="nav-link submenu">상품 등록</a>

		<a href="#" class="menu-header">
			<i class="fas fa-cogs"></i> 사이트 설정
		</a>

		@guest('manager')
		<a href="#" class="menu-header">
			<i class="fas fa-sign-in-alt"></i> 로그인
		</a>
		@endguest
		@auth('manager')
		<form method="POST" class="menu-header" action="/manager/logout" id="logoutForm" onclick="onClickLogout()">
			@csrf
			<i class="fas fa-sign-in-alt"></i> 로그아웃
		</form>
		<a href="#" class="nav-link submenu">계정 설정</a>
		@endauth
	</div>
</div>
<script>
	const onClickLogout = () => {
		const form = document.querySelector('#logoutForm');
		form.submit();
	}
</script>
<style>
    .menu-header, .nav-link {
        transition: all 0.2s ease;
        position: relative;
        padding-left: 15px;
    }

    .menu-header:hover, .nav-link:hover {
        background-color: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }

    .menu-header:hover i, .nav-link:hover i {
        color: #3498db;
    }

    /* 현재 활성화된 메뉴 스타일 */
    .menu-header.active, .nav-link.active {
        background-color: rgba(52, 152, 219, 0.15);
        border-right: 3px solid #3498db;
        color: #3498db;
    }

    /* submenu 스타일 조정 */
    .submenu {
        padding-left: 30px;
    }

    /* disabled 메뉴 스타일 */
    .submenu.disabled {
        cursor: default;
        pointer-events: none;
        color: inherit;  /* 부모 요소의 색상을 상속 */
    }

    .submenu.disabled:hover {
        background-color: transparent;
        color: inherit;  /* 부모 요소의 색상을 상속 */
    }
    
    /* sub-submenu 스타일 추가 */
    .sub-submenu {
        padding-left: 45px;
        font-size: 0.9em;
        color: #666;
    }
    
    .sub-submenu:hover {
        color: #3498db;
    }
</style>