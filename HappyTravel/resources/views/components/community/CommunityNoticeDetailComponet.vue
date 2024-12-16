<template>
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
            <img src="/developImg/about-three1.png">
        </div>  
        <div class="notice_detail_content_box">
            <p class="notice_detail_content">내용</p>
        <textarea disabled cols="30" rows="30">{{ noticeDetailList.notice_content }}</textarea>                 
        </div> 
    </div>   
</template>

<script setup>
import { useStore } from 'vuex';
import { computed } from 'vue';

const store = useStore();

const noticeDetailList = computed(() => store.state.notice.noticeDetail);
    
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
        border-bottom : 1px solid black;    
       
    }
     /* 공지사항 상세 내용 */
    .notice_detail_content {    
        font-size: 1.2rem;
        color: #2986FF;
    }
    /* 공지사항 상세 내용 롱텍스트 */
    .notice_detail_content_box >textarea {        
             
        background-color: #EFEFEF;
        font-size: 1.2rem;
        font-weight: bold;
        line-height: 2;
        text-align: center;
        resize: none;
        overflow: hidden;
    }
    /* 공지사항 상세 이미지 */
    .notice_detail_file {
        text-align: center;       
    }
</style>