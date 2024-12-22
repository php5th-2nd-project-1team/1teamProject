<template>
        <div class="footer-img" style="display: flex; justify-content: flex-end;">
            <img src="/developImg/footer.png" alt="" style="width: 200px; height: 200px;">
        </div>
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
                    <li @click="pushAbout">펫브리즈 소개</li>
                    <li @click="pushPosts">펫브리즈 고</li>
                    <!-- <li>상품</li> -->
                    <li @click="pushNoticeList">커뮤니티</li>
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
</template>
<script setup>

import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const router = useRouter();
const store = useStore();

// about 페이지 이동 시
const pushAbout = function(){
	router.push('/about');
}

// posts 페이지 이동 시
const pushPosts = function(){
	router.push('/posts');
}

// 헤더 커뮤니티 이동 처리
const pushNoticeList = () => {
	store.commit('notice/setCurrentPage', 1); // page 1페이지로 초기화
	store.dispatch('notice/noticeList', 1); // 공지리스트 획득
	router.push('/community/notice'); // 이동
}
</script>
<style>
	
</style>