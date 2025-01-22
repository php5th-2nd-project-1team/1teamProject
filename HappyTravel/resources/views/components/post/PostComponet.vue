<template>
    <LoadingComponent v-if="isLoading"/>
    <div class="post-local">
        <!-- 상단 슬라이드 -->
        <div class="w-full">
            <swiper 
                :rewind="true"
                :navigation="{ nextEl:'.custom-next', prevEl:'.custom-prev'  }"
                :breakpoints= "breakpoints"
                :modules="modules"
                :loop="true"
                :observer="true"
                direction="horizontal"
                slidesPerView="3"
                spaceBetween="10"
                :width="400"
                class="mySwiper">
                    <!-- <swiper-slide @click="getLocalResult('')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>전체</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('01')"><img class="slide-img"  src="/developImg/seoul_icon.png" alt=""><p>서울</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('02')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>경기</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('03')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>강원</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('04')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>인천</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('05')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>세종</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('06')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>대전</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('07')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>충북</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('08')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>충남</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('09')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>경북</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('10')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>경남</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('11')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>전북</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('12')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>전남</p></swiper-slide>
                    <swiper-slide @click="getLocalResult('13')"><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>제주</p></swiper-slide> -->
                    <swiper-slide v-for="region in regions" :key="region.id" @click="selectRegion(region.id)">
                        <img class="slide-img" :src="region.img" alt="" :class="{ 'selected': selectedRegion === region.id }"><p>{{ region.name }}</p>
                    </swiper-slide>
                <div class="custom-prev"><img class="btn-slide-resize" src="/developImg/arrow_left.png" alt=""></div>
                <div class="custom-next"><img class="btn-slide-resize" src="/developImg/arrow_right.png" alt=""></div>
            </swiper>
        </div>   
    </div>
    <!-- 제목 -->
    <div class="post-title-area">
        <h1 class="post-title">{{ postThemeTitle }}</h1>
    </div>
    <!-- 검색 창 -->
    <div class="post-search">
        <div class="post-search-bg">
            <h3>#관광지 검색</h3>
            <input class="post-search-box" type="search" name="search" placeholder="검색어를 입력해주세요." v-model="searchData.search">
            <button class="btn btn-bg-blue btn-search" type="button" @click="getSearchResult">검색</button>
        </div>
    </div>
    <div class="post-searchResult-Count">
        <h2 style="margin-left: 45px;">검색 결과 : <span style="color:#007aff;">{{ postResultCnt }}</span>개</h2>
        <img @click="openFilterModal" class="post_filter" src="/developImg/fillter_icon.png" alt="">
        <PostFilterModalComponent v-show="isOpenFilterModal"  @postFilterClose=closeFilterModal />
    </div>
    <!-- 여행지 포스트 -->
    <div class="post-all">
        <div class="post-content">
            <PostCardComponent v-for="value in postList" :cardData="value"/>
        </div>
        <button class="btn btn-header btn-bg-gray btn-post-more" type="button" @click="store.dispatch('post/index')" v-if="!isLastPage">더 알아보기</button>
    </div>
</template>

<script setup>
// 상단 슬라이드
// Import Swiper Vue.js components


import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';

import 'swiper/css/navigation';

// import required modules
import { Navigation } from 'swiper/modules';
// import { reactive } from 'vue';

const modules = [Navigation];
// const modules = reactive([Navigation]);

const breakpoints = {

    850: {
        slidesPerView: 5,
        spaceBetween: 20,
        width: 750,
    },
    1370: {
        slidesPerView: 7,
        spaceBetween: 0,
        width: 1050,
    },
};

// 메인 출력 지역

import { useStore } from 'vuex';
import { computed, reactive, onUnmounted, onMounted, onBeforeMount, ref, watch } from 'vue';
import LoadingComponent from '../utilities/LoadingComponent.vue';
import PostCardComponent from './component/PostCardComponent.vue';
import PostFilterModalComponent from './component/PostFilterModalComponent.vue';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

// 지역 슬라이드 분기
const selectedRegion = ref('');
const selectRegion = (regionId) => {
    selectedRegion.value = regionId;
    getLocalResult(regionId);
};

const regions = [
    { id: '', name: '전체', img: '/developImg/all_icon.png'},
    { id: '01', name: '서울', img: '/developImg/seoul_icon.png'},
    { id: '02', name: '경기', img: '/developImg/gyeonggi_icon.png'},
    { id: '03', name: '강원', img: '/developImg/gangwon_icon.png'},
    { id: '04', name: '인천', img: '/developImg/incheon_icon.png'},
    { id: '05', name: '세종', img: '/developImg/sejong_icon.png'},
    { id: '06', name: '대전', img: '/developImg/daejeon_icon.png'},
    { id: '07', name: '충북', img: '/developImg/chungbuk_icon.png'},
    { id: '08', name: '충남', img: '/developImg/chungnam_icon.png'},
    { id: '09', name: '경북', img: '/developImg/geongbuk_icon.png'},
    { id: '10', name: '경남', img: '/developImg/geongnam_icon.png'},
    { id: '11', name: '전북', img: '/developImg/jeonbuk_icon.png'},
    { id: '12', name: '전남', img: '/developImg/jeonnam_icon.png'},
    { id: '13', name: '제주', img: '/developImg/jeju_icon.png'},
];

// -------------------------------------------
const postList = computed(() => store.state.post.postList);
const isLoading = computed(() => store.state.post.isLoading);
const isLastPage = computed(() => store.state.post.postList.length >= store.state.post.postResultCnt);
const postThemeTitle = computed(() => store.state.post.post_theme_title);

onBeforeMount(()=>{
    store.commit('post/setInitialize');
});

onMounted(()=>{
    store.commit('post/setPostThemeId', route.params.theme);
    store.dispatch('post/index', true);
});


// 검색 지역
const searchData = reactive({search : ''});
const postResultCnt = computed(() => store.state.post.postResultCnt);
const getSearchResult = () => {
    searchData.search.trim();

    if(searchData.search === ''){
        searchData.earch = null;
    }

    store.commit('post/setBeforeSearch', searchData.search);
    store.dispatch('post/index', 'keyword');
}

const getLocalResult = (num) => {
    store.commit('post/setBeforeLocal', num);
    store.dispatch('post/index', 'local');
}

// 포스트 필터 모달
const isOpenFilterModal = ref(false);
const openFilterModal = () => {
    isOpenFilterModal.value = true;
}

const closeFilterModal = () => {
    isOpenFilterModal.value = false;
}
</script>

<style scoped>

/* 슬라이드 */
.w-full {
    width: 60%;
    /* margin: 50px; */
    /* display: flex; */
    /* justify-content: center; */
  }

.swiper-slide {
    text-align: center;
    border: 2px solid transparent; /* 기본 상태는 투명 */
    transition: border 0.3s ease; /* 부드러운 전환 효과 */
}

.swiper-slide p {
    font-size: 15px;
}

.slide-img {
    border-radius: 50%;
    border: 4px solid transparent;
    width: 90px;
    padding: 0;
    cursor: pointer;
}

.selected {
    border: 4px solid #10b3ff;
}

.btn-slide-resize {
    width: 40px;
}

.custom-prev,
.custom-next {
  position: absolute;
  top: 40%;
  transform: translateY(-50%);
  z-index: 10;
  cursor: pointer;
}

.custom-prev {
  left: 0px;
  border-radius: 50%;
  text-align: center;
}

.custom-next {
  right: 0px;
  border-radius: 50%;
  text-align: center;
}

/* 제목 */
.post-title-area{
    width: 100%;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
}
/* -------------------------------------- */
/* 지역 선택 카테고리 */
.post-local {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 30px 0;
    width: 100%;
}

.post-local-arrow {
    width: 40px;
    height: 40px;
    cursor: pointer;
}
/* 검색창 */
.post-search {
    display: flex;
    margin: 20px;
    
}

.post-search-bg {
    background-color: #E7E7E7;
    margin: 20px auto;
    padding: 20px;
    width: 700px;
    border-radius: 20px;
    text-align: center;
}

.post-search-bg > h3 {
    margin-bottom: 10px;
}

.post-search-box {
    border: none;
    border-radius: 30px;
    padding: 10px;
    width: 400px;
}

.post-search-box:focus {
    outline: none;
}

/* 여행지 컨텐츠 */
.post-all {
    text-align: center;
    margin: 20px;
}

.post-content {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 20px;
}

/* 포스트 내용 더 알아보기 버튼 */
.btn-post-more {
    width: 200px;
    margin-top: 50px;
}

/* 검색버튼 */
.btn-search {
    width: 100px;
    margin: 20px 0 0 20px;
}

.post-searchResult-Count {
    display: flex;
    justify-content: space-between;
}

/* 필터 커스텀 */
.post_filter {
    width: 50px;
    margin-right: 30px;
    cursor: pointer;
}

/* 미디어 쿼리 */

/* @media screen and (min-width: 1024px) and (max-width: 1480px) {
    .post-content {
        margin-left: 60px;
    }
    .post-content-card-img {
        width: 350px;
    }
}

@media screen and (min-width: 500px)  and (max-width: 750px) {
    .post-search-bg {
        margin: 30px;
    }
}

@media screen and (min-width: 501px) and (max-width: 1023px) {
    .post-content {
        margin-left: 40px;
    }
    .post-content-card-img {
        width: 380px;
    }
}

@media screen and (max-width: 500px) {
    .post-content {
        margin-left: 40px;
    }
    .post-content-card-img {
        width: 400px;
    }
} */

@media screen and (max-width: 1450px) {
    /* .custom-prev,
    .custom-next {
        display: none;
    } */
    /* .btn-slide-resize {
        width: 30px;
    } */
}

@media screen and (max-width: 1000px) {
    .custom-prev,
    .custom-next {
        display: none;
    }
}

/* @media screen and (max-width: 500px) {
    .post-local {
    width: 100%;
  }
} */

</style>