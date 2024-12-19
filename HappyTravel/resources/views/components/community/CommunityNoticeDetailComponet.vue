<template>
    <LoadingComponent v-if="LoadingFlg" />
    <div v-else-if="noticeDetailList.notice_id && !LoadingFlg">
        <div class="community_notice_detail_container">
            <h1>공지사항</h1> 
        <!-- 공지사항 태그 박스 -->
            <div class="notice_tag_detail_box">
                <div class="notice_tag_detail_number">
                    <p>{{ noticeDetailList.notice_id }}</p>
                </div>
                <div class="notice_tag_detail_manager">
                    <p>{{ noticeDetailList.managers.m_nickname }}</p>
                </div>
                <div class="notice_tag_detail_date">
                    <p>{{ noticeDetailList.created_at }}</p>
                </div>
            </div>
            <div class="notice_detail_title_box">
                <p class="notice_detail_title">제목</p>
                <p class="notice_detail_title_info">{{ noticeDetailList.notice_title }}</p>
            </div>   
            <div class="notice_detail_file">
                <p>첨부파일</p>
                <img v-if="noticeDetailList.notice_img !== null" :src="noticeDetailList.notice_img">
            </div>  
            <div class="notice_detail_content_box">
                <p class="notice_detail_content">내용</p>
                <div class="notice_detail_content_textarea" style="padding : 50px; height: auto; ">{{ noticeDetailList.notice_content }}</div>                 
            </div> 

            <div>
                <!-- <button @click="$route.push('/community/notice', noticeUrl)">이전</button> -->
                <router-link to="/community/notice"><button @click="goBack()">이전</button></router-link>                
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
      h1 { 
        margin: 20px;
    }
    .community_notice_detail_container {
        margin: 100px;
    }

    /* 공지사항 상세 태그 박스 */
    .notice_tag_detail_box {
        display: grid; 
        grid-template-columns:repeat(3,1fr);
        justify-content: space-around;
        gap:10px;
        border-top : 1px solid black;
        border-bottom : 1px solid black;
        padding: 20px; 
        margin:20px;  
        font-size: 1.5rem;
        font-weight: 300;
        color: #2986FF;
    }
    /* 공지사항 상세 제목 박스 */
    .notice_detail_title_box {
        display: grid;
        grid-template-columns: 40px 1fr;
        margin:20px;
        padding:20px;
        border-bottom : 1px solid black;
        text-align: center;
        line-height: 100px;
    }
    /* 공지사항 상세 제목 */
    .notice_detail_title {    
        font-size: 1.2rem;
        color: #2986FF;
    }
    /* 공지사항 상세 제목 정보 */
    .notice_detail_title_info {
        width: auto;
        min-height: 70px;
        background-color: #EFEFEF;
        border:1px solid #EFEFEF;
        font-size: 1.2rem;
        font-weight: bold;
        
    }
     /* 공지사항 상세 내용 박스 */
    .notice_detail_content_box {
        display: grid;
        grid-template-columns: 40px 1fr;        
        margin:20px;
        padding:20px;        
       
    }
     /* 공지사항 상세 내용 */
    .notice_detail_content {    
        font-size: 1.2rem;
        color: #2986FF;
    }
    /* 공지사항 상세 내용 롱텍스트 */
    .notice_detail_content_textarea {      
         background-color: #EFEFEF;
        font-size: 1.2rem;
        font-weight: bold;
        line-height: 2;
        resize: none;
        overflow: hidden;
    }
    /* .notice_detail_content_box >textarea {      
         background-color: #EFEFEF;
        font-size: 1.2rem;
        font-weight: bold;
        line-height: 2;
        resize: none;
        overflow: hidden;
    } */
    /* 공지사항 상세 이미지 */
    .notice_detail_file {
        display: grid;
        grid-template-columns: 40px 1fr;        
        margin:20px;
        padding:20px;        
        border-bottom : 1px solid black;         
    }   
    .notice_detail_file >p {
        color:#2986FF
    }
    .notice_detail_file >img {
        width:50px;
        height: 50px;
    }
</style>