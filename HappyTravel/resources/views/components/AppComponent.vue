<template>
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
                <div class="header-nav">
                    <!-- 햄버거 메뉴 -->
                    <div id="header-hamburger-menu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <!-- 상단 카테고리 -->
                    <!-- <ul id="header-nav-menu">
                        <a href=""><li class="header-nav-cate">펫브리즈 소개</li></a>

                        <li class="header-nav-cate">
                            <a href="">펫브리즈 고</a>
                            <ul class="nav-menu-sub">
                                <a href=""><li>클래스</li></a>
                                <a href=""><li>패키지</li></a>
                                <a href=""><li>굿즈</li></a>
                            </ul>
                        </li>
                        <li class="header-nav-cate">상품</li>
                        <li class="header-nav-cate">커뮤니티</li>
                    </ul> -->

                    <div id="header-nav-menu">
                        <div class="header-nav-cate">
                            펫브리즈 소개
                        </div>

                        <div class="header-nav-cate">
                            펫브리즈 고
                            <ul class="nav-menu-sub">
                                <li>숙소</li>
                                <li>식&음료</li>
                                <li>관광지</li>
                                <li>병원</li>
                            </ul>
                        </div>

                        <div class="header-nav-cate">
                            상품
                            <ul class="nav-menu-sub">
                                <li>클래스</li>
                                <li>패키지</li>
                                <li>굿즈</li>
                            </ul>
                        </div>

                        <div class="header-nav-cate">
                            커뮤니티
                            <ul class="nav-menu-sub">
                                <li>공지사항&이벤트</li>
                                <li>문의&질문</li>
                                <li>댕댕이 자랑관</li>
                            </ul>
                        </div>
                    </div>

                    <!-- <div class="header-nav-menu-box">
                        <p>클래스</p>
                        <p>패키지</p>
                        <p>굿즈</p>
                    </div> -->

            </div>
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
            <div>
                <p>찾아오시는 길: 경상북도 대구광역시</p>
                <p>만든사람: 펫타곤</p>
                <p>ⓒ 2024. ManduKing All rights reserved.</p>   
            </div>
            <div></div>
        </div>
    </footer>
</template>
    
<script setup> 

</script>
<style>
    @import url('../../css/common.css');
</style>