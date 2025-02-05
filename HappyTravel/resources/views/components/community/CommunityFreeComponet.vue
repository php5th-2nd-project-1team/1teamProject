<template>
    <LoadingComponent v-if="LoadingFlg" />
    <div class="free-title-bg">
        <h1>자유게시판</h1>
    </div>
    
    <div>
        <div class="serach-wrap">
            <!-- 왼쪽 섹션 -->
            <select class="select-box" v-model="search.type">
                <option value="all">전체</option>
                <option value="content">내용</option>
                <option value="title">제목</option>
                <option value="user">글쓴이</option>
                <option value="title_content">제목+내용</option>
            </select>
            
            <!-- 오른쪽 섹션 -->
            <div class="right-section">
                <input type="text" placeholder="검색어를 입력해주세요." maxlength="20" v-model="keyWord">
                <button class="search-button cursor-pointer" @click="serachPageReset">검색
                    <img src="/developImg/search_icon.png" alt="검색">
                </button>
            </div>
        </div>
            <div class="free-container">
                <div class="free-header">
                    <div class="free-item">No.</div>
                    <div class="free-item">제목</div>
                    <div class="free-item">글쓴이</div>
                    <div class="free-item">작성날자</div>
                    <div class="free-item">조회수</div>
                </div>
                <div v-for="item in boardList" :key="item" class="free-row">
                    <div class="free-item">{{ item.community_id }}</div>
                    <div class="free-item">{{ item.community_title }}</div>
                    <div class="free-item">{{ item.users?.nickname }}</div>
                    <div class="free-item">{{ item.created_at }}</div>
                    <div class="free-item">{{ item.community_view }}</div>
                </div>            
                <div></div>
                <div></div>
                <div></div> 
                <div></div> 
                <div class="board-wrtn">
                    <!-- <button  @click="router.push('/free/store')"><img class="free-pencil"src="/developImg/pencil.png"><span>글쓰기</span></button> -->
                    <button  @click="handleWriteButtonClick">
                        <img class="free-pencil"src="/developImg/pencil.png">
                        <span>글쓰기</span>
                    </button>
                </div>
            </div>
        <div class="pagination">
            <div v-for="item in links" :key="item.label" @click="scrollToTop()">
                <button class="paginate-btn" @click="$store.dispatch('boards/freeBoardList', getPageOnUrl(item.url))" v-if="(item.url !== null) && (isNaN(item.label) || (item.label >= (currentPage - limitPage) && item.label <= (currentPage + limitPage)))">
                <span class="paginate-btn-prev" v-if="item.label === backBtn"> {{ '이전' }}</span>
                <span class="paginate-btn-next" v-else-if="item.label === nextBtn">{{ '다음' }}</span>
                <span class="main-Btn" v-else-if="String(currentPage) === item.label">{{ item.label }}</span>
                <span  v-else>{{ item.label }}</span>
                </button>
            </div>
        </div>
    </div>    

</template>
    
<script setup>
    import LoadingComponent from '../utilities/LoadingComponent.vue';
    import {computed, onBeforeMount, reactive, ref} from 'vue';
    import { useRouter } from 'vue-router';
    import { useStore } from 'vuex';
    
    // 드롭다운에서 선택된 값 저장할 변수

    // 검색 
    const keyWord = ref('');
    const search = reactive({
        type: 'all',
        keyword: '',
        page: 0
    });
    
    const serachPageReset = () => {
        search.page = 0;
        search.keyword = keyWord.value;
        store.dispatch('boards/freeBoardList', search);
    }
    
    const store = useStore();

    const boardList = computed(()=>store.state.boards.boardList);

    const LoadingFlg = computed(() => store.state.boards.LoadingFlg);

    const router = useRouter();

    onBeforeMount(()=> { 
        store.dispatch('boards/freeBoardList', 0);
    });

    const links = computed(()=> store.state.boards.links);

    const backBtn = "&laquo; Previous";
    const nextBtn = "Next &raquo;";

    const currentPage = computed(()=> store.state.boards.currentPage);

    const limitPage = 2;

    const getPageOnUrl = (url) => {
        if(!url) {
            return;
        }

        const newSearch = {
            type: search.type,
            keyword: search.keyword,
            page: url.split('page=')[1]
        }

        console.log(newSearch);

        return newSearch;
    }
    
    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // 글쓰기 버튼 함수핸들러 
    const handleWriteButtonClick = () => { 
        const userInfo = localStorage.getItem('userInfo');

        if (userInfo) {
            router.push('/community/store');
        } else {
            alert('로그인이 필요합니다');
            router.push('/login');
        }
    }

</script>

<style scoped>
    .free-title-bg {  
        font-size: 2rem;
        padding: 15px;
        margin: 0 auto;
        width: 80%;
        text-align: center;
        margin-bottom: 50px;
    }

    .free-container {
        width: 80%;
        margin: 20px 0;
        margin: 0 auto;
        margin-top: 10px;
        display: grid; /* 전체 컨테이너에 그리드 적용 */
        grid-template-columns: 1.5fr 2.5fr 2fr 1fr 1fr; /* 각 항목의 너비 설정 */
    }

    .free-header, .free-row {
        display: contents; /* 내용만 표시하고 부모 요소는 그리드 항목으로 활용 */
        background-color: #2986FF;
    }
    
    .free-item {
        background-color: #2986FF;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        border-bottom: 1px solid #D9D9D9; /* 각 항목 사이의 구분선 */        
        display: flex;
        justify-content: center;
        align-items: center;
        /* 텍스트 줄 바꿈 방지 */
        white-space: nowrap;        
        /* 너무 긴 텍스트를 잘라내고 '...' 추가 */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .free-row .free-item {
        background-color: #fff;
        color: #333;
        font-size:0.8rem;

    }
    .free-row:hover .free-item {
        background-color: #f9f9f9;
    } 
    .serach-wrap {
    width: 80%;
    margin: 20px 0;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 2fr; /* 왼쪽 1열, 오른쪽 1열 */
    align-items: center; /* 세로 가운데 정렬 */

    }
    .select-box {
        width:30%;
        padding: 8px;
    }
    .right-section {
        display: flex;
        justify-content: flex-end; /* 오른쪽 정렬 */
        align-items: center; /* 세로 가운데 정렬 */
        gap: 10px; /* 입력 필드와 버튼 사이 간격 */
    }
    input {
        width: 30%;
        padding: 8px;
    }
    .search-button {
        background-color: #2986FF;
        color: #fff;
        font-size: 1rem;
        width:10%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4px;
    }
    .search-button img  {
        width: 30px; /* 이미지 너비 */
        margin-left :8px;
    }
    .cursor-pointer {
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

    /* 게시글 작성 */
    .board-wrtn {
        display: flex;
        justify-content: right;
        margin-top: 20px;
    }  
    .board-wrtn button {
      background-color: #2986FF;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 5px;
      font-size: 20px;
      font-weight: bold;
      border: none;
      width: 80%;
    }
    .board-wrtn button span {
        /* width: 30px;
        height: 30px; */
        /* margin-right: 5px; */
        padding-top: 5px;
    }
    .free-pencil  {
        width: 20px;
        height: 18px;
        margin-right: 10px;
    }

</style>