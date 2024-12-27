    <template>
    <LoadingComponent v-if="LoadingFlg" />

    <div class="notice-title-bg" >
        <h1 class="notice-cursor-pointer">공지사항</h1>
    </div>

    <div class="notice-container">
      <div class="notice-header">
          <div class="notice-item notice-cursor-pointer">공지</div>
          <div class="notice-item">제목</div>
          <div class="notice-item notice-cursor-pointer">작성자</div>
          <div class="notice-item notice-cursor-pointer">작성일자</div>
      </div>
        
      <div v-for="item in noticeImportantList" :key="item" class="notice-row">
          <div class="notice-item">
             <span class="notice-inportant">중요</span>  
          </div> 
          <div class="notice-item notice-title notice-cursor-pointer" @click="redirectDetaile(item.notice_id)">{{ item.notice_title }}</div>
          <div class="notice-item">{{ item.managers.m_nickname }}</div>
          <div class="notice-item">{{ item.created_at }}</div>
      </div>

      <div v-for="item in noticeList" :key="item" class="notice-row">
          <div class="notice-item">
             <span  class="notice-common">일반</span>
          </div> 
          <div class="notice-item notice-title notice-cursor-pointer" @click="redirectDetaile(item.notice_id)">{{ item.notice_title }}</div>
          <div class="notice-item">{{ item.managers.m_nickname }}</div>
          <div class="notice-item">{{ item.created_at }}</div>
      </div>

    </div>

    <div class="pagination">      
      <div v-for="item in links" :key="item.label" @click="scrollToTop()">
        <button class="paginate-btn" @click="$store.dispatch('notice/noticeList', getPageOnUrl(item.url))" v-if="(item.url !== null) && (isNaN(item.label) || (item.label >= (currentPage - limitPage) && item.label <= (currentPage + limitPage)))">
            <span class="paginate-btn-prev" v-if="item.label === backBtn">{{ '이전' }}</span> 
            <span class="paginate-btn-next" v-else-if="item.label === nextBtn">{{ '다음' }}</span>
            <span class="main-Btn" v-else-if="String(currentPage) === item.label">{{ item.label }}</span>
            <span  v-else>{{ item.label }}</span>
        </button>
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
    const noticeImportantList = computed(() => store.state.notice.noticeImportant);

    onBeforeMount(() => {
            store.dispatch('notice/noticeList', 0);
            // console.log(noticeImportantList);
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

    .notice-cursor-pointer {
      cursor: pointer;
    }
    .notice-title-bg {  
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
      font-size: 1.3rem;
    }
    .notice-row {
      display: contents;
      font-size: 0.8rem;
    }
    .notice-item {
      text-align: center;
      padding: 10px;
      border-bottom: 1px solid  #D9D9D9; /* 게시글의 하단 보더 */
    }
    .notice-inportant {
      border:none;
      background-color: #2986FF;
      color:#fff;
      border-radius: 5px;
      padding: 5px;
    }
    .notice-common {
      border:none;
      background-color: #000;
      color:#fff;
      border-radius: 5px;
      padding: 5px;
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
    
    /* 버튼 박스 */
    .btn-box {
      margin:50px;
      text-align: right;
      align-items: center;
    }
    /* 버튼 커서  */
    button {
      cursor: pointer;
    }

    /* 페이지 */
    .pagination {
      display: flex;
      justify-content: center;
      margin: 20px 0;
      margin-top: 70px;
    }

    /* 페이지버튼 */
    .paginate-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      background-color: #fff;
    }   
    /* 현재 페이지 버튼 스타일 */
    .main-Btn {
      background-color: #2986FF;
      color: #fff;
      font-size: 20px;
      font-weight: bold;
      display: flex;
      justify-content: center;
      align-items: center;
      width:100%;
      height:100%;
    }
    /* 현재 페이지 호버시 색상변경 */
    .main-Btn:hover {
      background-color: #1A5BB8; 
    }
    /* 이전, 다음 버튼 스타일 */
    .paginate-btn-prev,
    .paginate-btn-next {
      background-color: #2986FF; /* 배경색 */
      color: #fff; /* 글자 색 */
      font-size: 16px; /* 글자 크기 */
      font-weight: bold; /* 글자 두껍게 */
      display: flex;
      align-items: center; /* 세로 가운데 정렬 */
      justify-content: center; /* 가로 가운데 정렬 */
      width: 50px; /* 버튼 크기 */
      height: 50px; /* 버튼 크기 */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    /* 이전, 다음 버튼 호버 시 색상 변경 */
    .paginate-btn-prev:hover,
    .paginate-btn-next:hover {
      background-color: #1A5BB8; 
    }

</style>