<template>
    <div class="community_notice_container">
            <h1>공지사항</h1> 
        <!-- 공지사항 태그 박스 -->
        <div class="notice_tag_box">
            <div class="notice_tag_number">
                <p>번호</p>
            </div>
            <div class="notice_tag_title">
                <p>제목</p>
            </div>  
            <div class="notice_tag_manager">
                <p>작성자</p>
            </div>
            <div class="notice_tag_date">
                <p>작성일자</p>
            </div>
            <div class="notice_tag_file">
                <p>파일</p>
            </div>      
        </div>
        <!-- 공지사항 컨텐츠 박스 -->
        <div v-if="LoadingFlg"> 로딩 중 </div>
        <div v-else v-for="item in noticeList" :key="item" class="notice_content_box">
            <div class="notice_content_num">
                <p>{{ item.notice_id }}</p>
            </div>      
            <div class="notice_content_title">              
                <p>{{ item.notice_title }}</p>              
            </div>  
            <div class="notice_content_manager">
                <p>{{ item.m_nickname }}</p>
            </div>
            <div class="notice_content_date">
                <p>{{ item.created_at }}</p>
            </div>
            <div>
                <img :src="item.img">
            </div>     
        </div>
        <div class="pagination">
            <button>이전</button>
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <button>다음</button>
        </div>
    </div>
</template>

<script setup>    
    import { computed, onBeforeMount } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();
    const LoadingFlg = computed(() => store.state.notice.LoadingFlg);
    const noticeList = computed(() => store.state.notice.noticeList);
    onBeforeMount(() =>store.dispatch('notice/noticeList'));
    
</script>

<style scoped>
    * {
  box-sizing: border-box;
    }

    body {
     margin: 0;
    padding: 0;
    }
    .community_notice_container {
        min-width: 800px;
    }
    h1 { 
        margin: 20px;
    }
    /* 공지사항 태그 박스  */
    .notice_tag_box {
    display: grid; 
    grid-template-columns:repeat(5,1fr);
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
    /* 공지사항 콘텐츠 박스  */
    .notice_content_box {
    display: grid;
    grid-template-columns:repeat(5,1fr);  
    justify-items: start;
    align-items: center;
    gap: 10px;    
    background-color: #EFEFEF;
    width:auto;
    font-size: 0.8rem;
    font-weight: bold;
    height: 50px;
    margin: 20px;  
    min-width: 500px;
    }
    .notice_content_num >p {
        margin-left:35px;
    }
    .notice_content_title >p {
        margin-right:35px;
        min-width: 100px;
    }
    .notice_content_manager >p {
        margin-left:35px;
    }
    /* 첨부 파일 이미지 */
    .link_file {
    width:30px;
    height:30px;
    }
    /* 버튼 박스 */
    .btn_box {
        margin:50px;
        text-align: right;
        align-items: center;
    }
    /* 페이지 */
    .pagination {
        text-align: center;
    }
    
</style>