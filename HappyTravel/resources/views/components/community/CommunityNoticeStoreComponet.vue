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
         <!-- LoadingFlg -->
         <LoadingComponent v-if="LoadingFlg" />
        <div v-else v-for="item in noticeList" :key="item" class="notice_content_box">
            <div class="notice_content_num" id="{{ itme.notice_id }}">
                <p>{{ item.notice_id }}</p>
            </div>      
            <div class="notice_content_title"> 
                <p @click="redirectDetaile(item.notice_id)">{{ item.notice_title }}</p>     
            </div>  
            <div class="notice_content_manager">
                <p>{{  item.managers.m_nickname}}</p>
            </div>
            <div class="notice_content_date">
                <p>{{ item.created_at }}</p>
            </div>
            <div class="link_file">
                <img v-if="item.notice_img !== null" :src="item.notice_img">
            </div>     
        </div>
        <!--    <div class="pagination">
            <div v-for="item in links" :key="item.label">
                <button class="pagenate-btn" @click="$store.dispatch('notice/noticeLinkList', item.url)" v-if="(item.url !== null) && (isNaN(item.label) || (item.label >= (currentPage - limitPage) && item.label <= (currentPage + limitPage)))">
                    <span v-if="item.label === backBtn">{{ '이전' }}</span> 
                    <span v-else-if="item.label === nextBtn">{{ '다음' }}</span>
                    <span class="main-Btn" v-else-if="String(currentPage) === item.label">{{ item.label }}</span>
                    <span v-else>{{ item.label }}</span>
                </button>
            </div>
        </div> -->
        <div class="pagination">
            <div v-for="item in links" :key="item.label" @click="scrollToTop()">
                <button class="pagenate-btn" @click="$store.dispatch('notice/noticeList', getPageOnUrl(item.url))" v-if="(item.url !== null) && (isNaN(item.label) || (item.label >= (currentPage - limitPage) && item.label <= (currentPage + limitPage)))">
                    <span v-if="item.label === backBtn">{{ '이전' }}</span> 
                    <span v-else-if="item.label === nextBtn">{{ '다음' }}</span>
                    <span class="main-Btn" v-else-if="String(currentPage) === item.label">{{ item.label }}</span>
                    <span  v-else>{{ item.label }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>    
    import LoadingComponent from '../utilities/LoadingComponent.vue';
    import { computed, onBeforeMount} from 'vue';
    import { useStore } from 'vuex';
    import router from '../../../js/router.js';

    const store = useStore();
    const LoadingFlg = computed(() => store.state.notice.LoadingFlg);
    const noticeList = computed(() => store.state.notice.noticeList);

    onBeforeMount(() => {
            store.dispatch('notice/noticeList', 0);
        }
    );
   
    const links = computed(()=> store.state.notice.links);

    const backBtn = "&laquo; Previous";
    const nextBtn = "Next &raquo;";

    const currentPage = computed(() => store.state.notice.currentPage);
    
    const limitPage = 2;

    // url에서 페이지 번호만 획득
    const getPageOnUrl = (url) => {
        if(!url) {
            return;
        }
        return url.split('page=')[1];
    }
    
    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const redirectDetaile = (id) => {
        scrollToTop();
        router.push('/community/notice/' + id);
    };
    
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
        cursor:pointer;
    }
    .notice_content_manager >p {
        margin-left:35px;
    }
    /* 첨부 파일 이미지 */
    .link_file >img{
    width:30px;
    height:30px;
    }
    /* 버튼 박스 */
    .btn_box {
        margin:50px;
        text-align: right;
        align-items: center;
    }

    button {
        cursor: pointer;
    }

    /* 페이지 */
    .pagination {
        display: flex;
        justify-content: center;
    }    
    .pagenate-btn {
        width:50px;
        height: 50px;
        border-radius: 50px;
        border:none;
        color:black;
    }
    .main-Btn {
        font-size: 30px;
        border:none;
        color: darkblue;
    }
</style>