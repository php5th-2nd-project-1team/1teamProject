<template>
    <LoadingComponent v-if="LoadingFlg" />

    <div class="notice_title_bg" >
        <h1 class="notice_title">공지사항</h1>
    </div>

    <div class="notice-container">
        <div class="notice-header">
            <div class="notice-item">공지</div>
            <div class="notice-item">제목</div>
            <div class="notice-item">작성자</div>
            <div class="notice-item">작성일자</div>
        </div>
            <!-- <div class="notice-row">
            <div class="notice-item">1</div>
            <div class="notice-item">공지사항 제목</div>
            <div class="notice-item">관리자</div>
            <div class="notice-item">2024-12-20</div>
            </div>
            -->    
        <div v-for="item in noticeList" :key="item" class="notice-row">
            <div class="notice-item notice_inportant" v-if="item.notice_tag === '1'">중요</div> 
            <div class="notice-item notice_common" v-else-if="item.notice_tag === '0'">일반</div> 
            <div class="notice-item">{{ item.notice_title }}</div>
            <div class="notice-item">{{ item.managers.m_nickname }}</div>
            <div class="notice-item">{{ item.created_at }}</div>
        </div>
    </div>

    <!-- <div class="pagination">
        <button class="prev-next">이전</button>
        <button class="page-number">1</button>
        <button class="page-number">2</button>
        <button class="page-number active">3</button>
        <button class="page-number">4</button>
        <button class="page-number">5</button>
        <button class="prev-next">다음</button>
    </div> -->

    
    <div class="pagination">      
        <button @click="$store.dispatch('notice/noticeList', getPageOnUrl(item.url))" class="page-number" v-for="item in links" :key="item.label">{{ item.label }}</button> 
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
    .notice_title_bg {  
        font-size: 2rem;
        padding: 15px;
        margin:0 auto;
        width: 80%;
        text-align: center;
    }
    .notice-container {
      display: grid;
      grid-template-columns: 0.5fr 3fr 1fr 1fr; /* 번호를 줄이고 제목을 늘림 */
      width: 80%;
      margin: 20px 0;
      margin: 0 auto;
      margin-top: 50px;
    }
    .notice-header {
      display: contents;
    }
    .notice-row {
      display: contents;
    }
    .notice-item {
      text-align: center;
      padding: 10px;
      border-bottom: 1px solid  #D9D9D9; /* 게시글의 하단 보더 */
    }
    .notice-header .notice-item {
      background-color: #2986FF;
      color: #fff;
      font-weight: bold;
      border-top: 2px solid #2986FF; /* 헤더의 상단 보더 */
      padding: 10px;
    }
    .notice-row:hover .notice-item {
      background-color: #f9f9f9;
    }
    
    .pagination {
      display: flex;
      justify-content: center;
      margin: 20px 0;
      gap: 4px;
    }
    .pagination .prev-next {
      background-color: #2986FF;
      color: #fff;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
    }
    .pagination .prev-next:hover {
      background-color: #0056b3;
    }
    .pagination .page-number {
      font-size: 16px;
      color: #000;
      cursor: pointer;
      border: none;
      background: none;
      padding: 0;
      width:40px;
      height: 40px;
      line-height: 40px;
      text-align: center;
    }
    .pagination .page-number.active {
      font-size: 20px;
      font-weight: bold;
      background-color: #2986FF;
      color: #ffff;
      width:40px;
      height: 40px;
      line-height: 40px;
      text-align: center;    
    }
    .pagination .page-number:hover {
      text-decoration: underline;
    }






</style>