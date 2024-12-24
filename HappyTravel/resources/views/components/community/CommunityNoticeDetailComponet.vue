<template>
    <LoadingComponent v-if="LoadingFlg" />
    <div v-else-if="noticeDetailList.notice_id && !LoadingFlg">
      <div class="community-notice-detail-container">
                <h1>공지사항</h1> 
                <br><br>
        <div class="container">
            <div class="community-notice-detail-header">
                <div class="community-notice-detail-header-left-tag" v-if="noticeDetailList.notice_tag === '0'">
                    <span>일반</span>
                </div>
                <div class="community-notice-detail-header-left-tag-important" v-else>
                    <span>중요</span>                  
                </div>
                <div class="community-notice-detail-header-right">
                    <div class=community-notice-detail-header-right-top>
                        <span>{{ noticeDetailList.notice_title }}</span>
                    </div>
                    <div class="community-notice-detail-header-right-bottom">
                        <span>{{ noticeDetailList.managers.m_nickname }}</span>
                        <span>{{ noticeDetailList.created_at }}</span>
                    </div>
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
        height:150px;       
        border: 1px solid #BDBDBD;
    }
    /* 새로작성한 구간 */
  
    .community-notice-detail-header-left-tag {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 180px;
        background-color: #BDBDBD;
        color:#fff;
        font-size:1.8rem;
    }
    .community-notice-detail-header-left-tag-important {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 180px;
        background-color: #2986FF;
        color:#fff;
        font-size:1.8rem;
    }
    .community-notice-detail-header-right { 
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
    }
    .community-notice-detail-header-right-top {
        display:flex;
        justify-content: center;
        height: 100%;
        align-items: center;
        font-size: 2rem;
    }
    
    .community-notice-detail-header-right-bottom {
        display: flex;
        justify-content: flex-end;
        width:100%;
        padding:10px;
        margin-right: 30px;
        gap: 100px;
        font-size:1rem;
        border-top: 1px solid #BDBDBD;
        color:#000;
    }

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
    .image img {
    width: 100%;   /* 이미지 너비를 div에 맞게 100% */
    height: 100%;  /* 이미지 높이를 div에 맞게 100% */
    object-fit: cover; /* 이미지가 div 크기에 맞게 비율 유지하며 잘라냄 */
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



