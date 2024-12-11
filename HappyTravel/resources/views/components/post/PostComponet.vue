<template>
    <div class="post-local">
        <!-- 상단 슬라이드 -->
        <div class="w-full">
            <swiper 
                :rewind="true"
                :navigation="{ nextEl:'.custom-next', prevEl:'.custom-prev'  }"
                :breakpoints= "breakpoints"
                :modules="modules"
                :loop="true"
                direction="horizontal"
                slidesPerView="3"
                spaceBetween="10"
                class="mySwiper">
                <!-- <div class="slide-container"> -->
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>서울</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>경기도</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>강원도</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>인천</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>세종</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>충청북도</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>충청남도</p></swiper-slide>
                    <swiper-slide><img class="slide-img" src="/developImg/seoul_icon.png" alt=""><p>제주</p></swiper-slide>
                <!-- </div> -->
                <div class="custom-prev"><</div>
                <div class="custom-next">></div>
            </swiper>
        </div>



        <!-- 왼쪽 화살표 -->
        <!-- <img class="post-local-arrow" src="/developImg/arrow_left.png" alt=""> -->
        <!-- 상단 지역 카테고리 -->
        <!-- <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>경기도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>강원도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>인천</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>세종</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>대전</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>충청북도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>충청남도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>경상북도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>경상남도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>전라북도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>전라남도</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="/developImg/seoul_icon.png" alt="">
            <p>제주</p>
        </div> -->
        <!-- 오른쪽 화살표 -->
        <!-- <img class="post-local-arrow" src="/developImg/arrow_right.png" alt=""> -->
    </div>
    <!-- 검색 창 -->
    <div class="post-search">
        <div class="post-search-bg">
            <h3>#관광지 검색</h3>
            <input class="post-search-box" type="search" name="search" placeholder="검색어를 입력해주세요.">
            <button class="btn btn-bg-blue btn-search" type="button">검색</button>
        </div>
    </div>
    <!-- 여행지 포스트 -->
    <div class="post-all">
        <div class="post-content">
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
        </div>
        <button class="btn btn-header btn-bg-gray btn-post-more" type="button">더 알아보기</button>
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

    768: {
        slidesPerView: 5,
        spaceBetween: 20,
    },
    1350: {
        slidesPerView: 7,
        // spaceBetween: 30,
    },
};

// -----------------------------------------

</script>

<style scoped>
.w-full {
    width: 60%;
    margin: 50px;
    display: flex;
    justify-content: center;
  }

  .swiper-slide {
    /* width: 200px; */
    /* font-weight: 700; */
    height: 200px;
    text-align: center;
}

    .slide-img {
      border-radius: 50%;
      border: 3px solid #10b3ff;
    }
  
/* .slide-container {
    display: flex;
    justify-content: center;
} */

.custom-prev,
.custom-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  cursor: pointer;
}

.custom-prev {
  left: 10px;
  width: 50px;
  height: 50px;
  background-color: #000;
  color: #fff;
  border-radius: 50%;
  text-align: center;
}

.custom-next {
  right: 10px;
  width: 50px;
  height: 50px;
  background-color: #000;
  color: #fff;
  border-radius: 50%;
  text-align: center;
}
/* -------------------------------------- */
/* 지역 선택 카테고리 */
.post-local {
    display: flex;
    justify-content: center;
    align-items: center;
}

.post-local-item {
    text-align: center;
    padding: 20px;
}

.post-local-item-img {
    border-radius: 50%;
    width: 80px;
    height: 80px;
}

.post-local-item-img:hover {
    box-shadow: 0 0 0 2px #000;
}

.post-local-arrow {
    width: 40px;
    height: 40px;
    cursor: pointer;
}
/* 검색창 */
/* .post-search {
    display: grid;
    grid-template-columns: 1fr 1fr;
} */

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
    padding: 20px;

}

.post-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: center;
    gap: 20px;
    /* margin: 50px; */
    margin-left: 100px;
}

.post-content-card {
    margin-bottom: 30px;
    text-align: center;
}

.post-content-card-img {
    width: 400px;
    border-radius: 30px;
    opacity: 1;
    transition: .2s ease-in-out;
    /* -webkit-transition: .2s ease-in-out; */
}

.post-content-card-img:hover {
    opacity: .8;
}

.btn-post-more {
    width: 200px;
    
}

</style>