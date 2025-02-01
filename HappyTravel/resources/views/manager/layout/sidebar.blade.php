<div class="sidebar">
	<div class="logo">
		<img src="{{ asset('images/logo.png') }}" alt="로고">
	</div>
	
	<div class="nav flex-column">
		<a href="#" class="menu-header">
			<i class="fas fa-users"></i> 유저
		</a>
		<a href="#" class="nav-link submenu">신고</a>
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

		<a href="#" class="menu-header">
			<i class="fas fa-sign-in-alt"></i> 로그인
		</a>
		@auth
			<a href="#" class="nav-link submenu">계정 설정</a>
		@endauth
	</div>
</div>