<template>
    <div class="mypage-container-title">
        <h1>찜 목록</h1>
    </div>
    <hr>
    <div class="container">
        <div class="container-category">
            <div class="category">포스트</div>
            <div class="category">상품</div>
        </div>
        <div class="content-all">
            <div class="content-card" v-for="(item, key) in wishlistPost" :key="key">
                <div class="img-container">
                    <img class="img-like" src="/developImg/like_yes.png" alt="">
                    <img class="content-img" :src="item.post_img" alt="">
                </div>
                <h3 class="content-title">{{ item.post_title }}</h3>
                <p class="content-local">{{ item.post_local_name }}</p>
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

    <div class="button-container">
        <button @click="$router.push('/')">홈으로</button>
    </div>
</template>
<script setup>
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

// import PostCardComponent from '../post/component/PostCardComponent.vue';
import { computed, onBeforeMount, onMounted } from 'vue';

const store = useStore();
const router = useRouter();

const wishlistPost = computed(() => store.state.user.myPageWishlistPost);
onMounted(() => {
    store.dispatch('user/myPageWishlistPost');
})

// 페이지네이션
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




</script>
<style scoped>
* {
    margin: 0;
    padding: 0;
    /* display: inline-block; */
}

.mypage-container-title {
    display: flex;
    justify-content: space-between;
}

.home-btn {
    padding: 12px 20px;
    margin: 5px;
    font-size: 16px;
    background-color: #2986FF;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.home-btn:hover {
    background-color: #CDECFF;
    transform: translateY(-2px);
}
   
.container {
    width: 100%;
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.container-category {
    display: flex;
    justify-content: flex-start;
    gap: 30px;
}

.category {
    color: #BDBDBD;
    font-size: 30px;
    cursor: pointer;
}

.category:hover {
    color: #000;
}

h1 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

hr {
    margin-bottom: 10px;
    border: 2px solid #BDBDBD;
}
.content-card {
    width: calc(33.33% - 20px);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    cursor: pointer;
}

.info-group {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

label {
    font-size: 16px;
    color: #333;
    font-weight: bold;
    width: 100px;
}

.info-text {
    font-size: 16px;
    color: #555;
    padding: 10px 20px ;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f1f1f1;
    font-weight: 900;
}

.info-group p {
    margin: 0;
}

.button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.button-container button {
    padding: 12px 20px;
    margin: 5px;
    font-size: 16px;
    background-color: #2986FF;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.button-container button:hover {
    background-color: #CDECFF;
    transform: translateY(-2px);
}

.content-all {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 20px;
    margin-top: 20px;
}



.content-title {
    text-align: center;
}

.content-local {
    text-align: center;
}

.img-container {
    position: relative;
    width: 100%;
}

.content-img {
    width: 100%;
    border-radius: 10px;
}

.img-like {
    position: absolute;
    right: 10px;
    top: 10px;
    border-radius: 50%;
    width: 50px;
    height: 50px;
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