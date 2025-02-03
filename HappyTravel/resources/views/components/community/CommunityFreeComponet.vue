<template>
    <div class="free-title-bg">
        <h1>자유게시판</h1>
    </div>
    
    <div>
        <div class="serach-wrap">
            <!-- 왼쪽 섹션 -->
            <select class="select-box"v-model="selectOpiton">
                <option value="all">전체</option>
                <option value="content">내용</option>
                <option value="title">제목</option>
                <option value="user">글쓴이</option>
                <option value="titleContent">제목+내용</option>
            </select>
            
            <!-- 오른쪽 섹션 -->
            <div class="right-section">
                <input type="text" placeholder="검색어를 입력해주세요." maxlength="20">
                <button class="search-button cursor-pointer">검색
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
                <div class="free-row">
                    <div class="free-item">999.</div>
                    <div class="free-item">나나나나노노노노노(121)</div>
                    <div class="free-item">둘리</div>
                    <div class="free-item">2025-01-22 09:01:52</div>
                    <div class="free-item">15</div>
                </div>            
            </div>
        <div class="pagination">
            <div v-for="item in links" :key="item.label" @click="scrollToTop()">
                <button class="paginate-btn" @click="$store.dispatch('board/boardList', getPageOnUrl(item.url))" v-if="(item.url !== null) && (isNaN(item.label) || (item.label >= (currentPage - limitPage) && item.label <= (currentPage + limitPage)))">
                <span class="paginate-btn-prev" v-if="item.label === backBtn"> {{ '이전' }}</span>
                <span class="paginate-btn-next" v-else-if="item.label === nextBtn">{{ '다음' }}</span>
                <span class="main-Btn" v-else-if="String(currentPage) === item.label">{{ item.label }}</span>
                <span  v-else>{{ item.label }}</span>
                </button>
            </div>
        <button  @click="router.push('/free/store')">글쓰기</button>
        </div>
    </div>    

</template>
    
<script setup>
    import {computed, onBeforeMount, ref} from 'vue';
    import { useStore } from 'vuex';
    
    // 드롭다운에서 선택된 값 저장할 변수
    const selectOpiton = ref('all');

    const store = useStore();

    const boardList = computed(()=>store.state.board.boardList);

    onBeforeMount(()=> { 
        store.dispatch('board/freeBoardList', 0);
    });

    const links = computed(()=> store.state.board.links);

    const backBtn = "&laquo; Previous";
    const nextBtn = "Next &raquo;";

    const currentPage = computed(()=> store.state.board.currentPage);
    const limitPage = 2;

    const getPageOnUrl =(url) => {
        if(!url) {
            return;
        }
        return url.split('page=')[1];
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
</style>