<template>
	<!-- header -->
		<header>
	<div class="header-container">
		<div class="header-top">
			<!-- 로고 -->
			<h1>
				<a href="/Petbreeze">
					<img class="header-logo" src="/developImg/petbreeze_logo.png" alt="펫브리즈">
				</a>
			</h1>
			<!-- 네비게이션 -->
			<!-- <div class="header-nav"> -->
				<!-- 상단 카테고리 -->
				<!-- <div id="header-nav-menu">
					<div class="header-nav-cate">
						펫브리즈 소개
					</div> -->

					<!-- <div class="header-nav-cate">
						펫브리즈 고
						<ul class="nav-menu-sub">
							<li>숙소</li>
							<li>식&음료</li>
							<li>관광지</li>
							<li>병원</li>
						</ul>
					</div> -->
<!-- 
					<div class="header-nav-cate">
						상품
						<ul class="nav-menu-sub">
							<li>클래스</li>
							<li>패키지</li>
							<li>굿즈</li>
						</ul>
					</div> -->

					<!-- <div class="header-nav-cate">
						커뮤니티
						<ul class="nav-menu-sub">
							<li>공지사항&이벤트</li>
							<li>문의&질문</li>
							<li>댕댕이 자랑관</li>
						</ul>
					</div>
				</div> -->
				<div class="header-nav">
					<!-- 햄버거 메뉴 -->
					<div id="header-hamburger-menu">
						<div></div>
						<div></div>
						<div></div>
					</div>
					<ul>
						<li><a href="">펫브리즈 소개</a></li>
						<li>
							<a href="">펫브리즈 고</a>
							<ul class="dropdown">
								<li class="dropdown-sub">숙소</li>
								<li class="dropdown-sub">식&음료</li>
								<li class="dropdown-sub">관광지</li>
								<li class="dropdown-sub">음료</li>
							</ul>
						</li>
						<li>
							<a href="">상품</a>
							<ul class="dropdown">
								<li class="dropdown-sub">클래스</li>
								<li class="dropdown-sub">패키지</li>
								<li class="dropdown-sub">굿즈</li>
							</ul>
						</li>
						<li><a href="">커뮤니티</a></li>
					</ul>
				</div>


		<!-- </div> -->
			<!-- 로그인, 회원가입 -->
			<div class="header-btn-group">
				<div v-if="!$store.state.user.authFlg">
					<router-link to="/login"><button class="btn btn-header btn-bg-blue" type="button">로그인</button></router-link>
					<router-link to="/registration"><button class="btn btn-header btn-bg-gray" type="button">회원가입</button></router-link>
				</div>
				<div v-else>
					<router-link to="/user/mypage"><button class="btn btn-header btn-bg-blue" type="button">마이페이지</button></router-link>
					<router-link to="logout"><button class="btn btn-header btn-bg-gray" type="button">로그아웃</button></router-link>
				</div>
			</div>
		</div>
	</div>
</header>
</template>
<script setup>

</script>
<style>
	
</style>