<template>
    <LoadingComponent v-if="LoadingFlg" />
    <div v-else-if="noticeDetailList.notice_id && !LoadingFlg">
      <div class="community-notice-detail-container">
                <h1>공지사항</h1> 
                <br><br>
        <div class="container">
            <!-- <div class="first-line">
                <span class="notice">공지</span>
                <span class="noticetitle">{{ noticeDetailList.notice_title }}</span>
            </div>
        
            <div class="second-line">
                <div class="left-group">
                    <span>작성자</span>
                    <span>{{ noticeDetailList.managers.m_nickname }}</span>
                </div>
                <div class="right-group">
                    <span>작성날짜</span>
                    <span>{{ noticeDetailList.created_at }}</span>
                </div>
            </div>
            <hr> -->
            <div class="community-notice-detail-header">
                <div class="community-notice-detail-header-tag">일반</div>
                <div>
                    <div>제목</div>
                    <div>작성자</div>
                    <div>작성일자</div>
                </div>
                
            </div>
        
            <div class="container">
                <div class="content">
                    <p>{{ noticeDetailList.notice_content }}</p>
                </div>
                <div class="image">
                    <!-- 이미지가 없으면 아래의 img 태그를 제외하거나 숨깁니다 -->
                    <img v-if="noticeDetailList.notice_img !== null" :src="noticeDetailList.notice_img">
                </div>
            </div>
            <hr>
            <div class="list_btn">
                <router-link to="/community/notice"><button class="btn btn-bg-blue btn-header" @click="goBack()">목록</button></router-link>
            </div>
        </div>
      </div>   
    </div>
</template>

<script setup>
import LoadingComponent from '../utilities/LoadingComponent.vue';
import { useStore } from 'vuex';
import { computed, onBeforeMount, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const store = useStore();

const noticeDetailList = computed(() => store.state.notice.noticeDetail);

const LoadingFlg = computed(() => store.state.notice.LoadingFlg);

const route = useRoute();

const router = useRouter();

const goBack = () => {
      router.go(-1); // 이전 페이지로 이동
      scrollToTop(); // 최상단으로 스크롤
    };

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    };


onBeforeMount(() => store.dispatch('notice/noticeDetailList', route.params.id));

</script>

<style scoped>

    .community-notice-detail-container {
        margin: 100px;
        padding:0 300px;
    }
    .community-notice-detail-header {
        display: flex;
        justify-content: space-between;
    }
    /* 새로작성한 구간 */
    .container {
    display: flex;
    flex-direction: column; 
    }
    .community-notice-detail-header {
    padding: 50px;
    border: 1px solid black;
    }
/* 
    .first-line {
    display: flex;
    align-items: center; 
    width: 100%;
    font-size: 3rem;
    
    }

    .notice {
    flex: 0 0 auto; 
    margin-right: 10px; 
    text-align: center;
    }

    .title {
    flex: 1; 
    text-align: center; 
    }

    .second-line {
    display: flex;
    justify-content: space-between; 
    align-items: center;
    width: 100%;
    font-size: 1.5rem;
    }

    .left-group {
    display: flex;
    gap: 10px; 
    }

    .right-group {
    display: flex;
    gap:10px;
    } */

    /* 컨텐츠  */
    .container {
    display: flex;
    flex-direction: column; /* 세로로 배치 */
    gap: 20px; /* 콘텐츠와 이미지 영역 사이의 간격 */
    }

    .content {
    flex: 1; /* 콘텐츠가 가능한 모든 세로 공간을 차지 */
    }

    .image {
    flex: 0; /* 이미지 영역은 기본적으로 공간을 차지하지 않음 */
    display: flex; /* 이미지를 중앙에 정렬 */
    align-items: center;
    justify-content: center;
    }

    /* 이미지가 없을 때 .image를 숨기기 */
    .image:empty {
    display: none; /* 이미지가 없으면 숨김 */
    }

    .list_btn {
        text-align: center;
        margin-top:20px;
    }
    .list_btn >.btn-header {
        font-size: 2rem;
        width:200px;
        height:50px;
        
    } 
</style>



