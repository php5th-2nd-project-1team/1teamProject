<template>
	<!-- header -->
		<header>
	<div class="header-container">
		<div class="header-top">
			<!-- 로고 -->
			<h1>
				<img @click="pushIndex" class="header-logo" src="/developImg/petbreeze_logo.png" alt="펫브리즈" style="cursor: pointer;">
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
						<li @click="pushAbout"><a>펫브리즈 소개</a></li>
						<li>
							<a>펫브리즈 고</a> 
							<ul class="dropdown" >
								<li @click="pushPosts('01')" class="dropdown-sub" style="cursor: pointer;">숙소</li>
								<li @click="pushPosts('02')" class="dropdown-sub" style="cursor: pointer;">식&음료</li>
								<li @click="pushPosts('03')" class="dropdown-sub" style="cursor: pointer;">관광지</li>
								<li @click="pushPosts('04')" class="dropdown-sub" style="cursor: pointer;">병원</li>
							</ul>
						</li>
						<li @click="pushShops">
							<a href="">상품</a>
							<!-- <ul class="dropdown">
								<li class="dropdown-sub">클래스</li>
								<li class="dropdown-sub">패키지</li>
								<li class="dropdown-sub">굿즈</li>
							</ul> -->
						</li>
						<li>
							<a>커뮤니티
							</a> 
							<ul class="dropdown" >
								<li @click="pushCommunity('01')" class="dropdown-sub" style="cursor: pointer;">공지사항</li>
								<li @click="pushCommunity('02')" class="dropdown-sub" style="cursor: pointer;">자유게시판</li>
								<li @click="pushCommunity('03')" class="dropdown-sub" style="cursor: pointer;">자랑게시판</li>
								<li @click="pushCommunity('04')" class="dropdown-sub" style="cursor: pointer;">문의게시판</li>
							</ul>
						</li>
					</ul>
				</div>


		<!-- </div> -->
			<!-- 로그인, 회원가입 -->
			<div class="header-btn-group">
				<div v-if="!$store.state.auth.authFlg">
					<router-link to="/login"><button class="btn btn-header btn-bg-blue" type="button">로그인</button></router-link>
					<router-link to="/registration"><button class="btn btn-header btn-bg-gray" type="button">회원가입</button></router-link>
				</div>
				<div v-else>
					<router-link to="/user/mypage"><button class="btn btn-header btn-bg-blue" type="button">마이페이지</button></router-link>
					<button @click="$store.dispatch('auth/logout')" class="btn btn-header btn-bg-gray" type="button">로그아웃</button>
				</div>
			</div>
		</div>
	</div>
</header>
</template>
<script setup>
import { useStore } from 'vuex';
import router from '../../../js/router.js'
import { ref } from 'vue';

const store = useStore();

const id = ref(store.state.auth.userInfo.user_id);

// 메인 페이지 이동 시
const pushIndex = function(){
	router.push('/');
}

// about 페이지 이동 시
const pushAbout = function(){
	router.push('/about');
}

// posts 페이지 이동 시
const pushPosts = function(post_num = null){
	if(post_num !== null){
		store.commit('post/setInitialize');
		store.commit('post/setPostThemeId', post_num);
		store.commit('post/setPostThemeTitle');

		store.dispatch('post/index', true);

		router.push(`/posts/${post_num}`);

		return;
	}
	
	router.push(`/posts`);
}

// shops 페이지 이동 시
const pushShops = function(){
	router.push('/shops');
}


// 헤더 커뮤니티 이동 처리
const pushNoticeList = () => {
	store.commit('notice/setCurrentPage', 1); // page 1페이지로 초기화
	store.dispatch('notice/noticeList', 1); // 공지리스트 획득
	router.push('/community/notice'); // 이동
}

// 커뮤니티 페이지로 이동시
const pushCommunity = (e) => { 
	if(e === '01') {
		pushNoticeList();
	}else if(e === '02') {
		router.push('/community/free');
	}else if(e === '03') {
		router.push('/community/photo');
	}else if(e === '04') {
		router.push('/inquiry');
	}	
}

</script>
<style>
	
</style>