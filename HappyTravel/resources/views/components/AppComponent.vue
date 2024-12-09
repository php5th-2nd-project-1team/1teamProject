<template>
<div class="container" style="display: flex; flex-direction: column; justify-content: space-between; height: 100vh;">
    <!-- header -->
    <header>
        <div class="header-container">
            <div class="header-top">
                <!-- 로고 -->
                <h1>
                    <a href="/Petbreeze">
                        <img class="header-logo" src="/img/petbreeze_logo.png" alt="펫브리즈">
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
                    <div>
                        <button class="btn btn-header btn-bg-blue" type="button">로그인</button>
                        <button class="btn btn-header btn-bg-gray" type="button">회원가입</button>
                    </div>
                    <!-- 나중에 조건문으로 로그인시엔 버튼 이거 띄우기 -->
                    <div class="header-btn-etc">
                        <button class="btn btn-header btn-bg-blue" type="button">마이페이지</button>
                        <button class="btn btn-header btn-bg-gray" type="button">로그아웃</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- main -->
    <main>
        <div>
            <router-view></router-view>
        </div>
    </main>

    <!-- footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <h3>Contact Us</h3>
                <p>이메일 : PettagonTeam1@gmail.com</p>
                <p>전화번호 : 053-0000-0000</p>
                <p>찾아오시는 길 : 대구광역시 그린컴퓨터아트 학원</p>
            </div>
            <div class="footer-content">
                <h3>Quick List</h3>
                <ul class="footer-list">
                    <li>펫브리즈 소개</li>
                    <li>펫브리즈 고</li>
                    <li>상품</li>
                    <li>커뮤니티</li>
                </ul>
            </div>
            <div class="footer-content">
                <h3>제작자</h3>
                <p><span>유원상:</span> #야호야호야호야호야호</p>
                <p><span>우민주:</span> #야호야호야호야호</p>
                <p><span>정한결:</span> #야호야호야호야호</p>
                <p><span>최상기:</span> #야호야호야호야호</p>
            </div>
        </div>
        <div class="footer-bottom-bar">Copyright 2021. 개인회사명 Co. All rights reserved.</div>
    </footer>
</div>
</template>
    
<script setup> 

</script>
<style>
    @import url('../../css/common.css');
</style>