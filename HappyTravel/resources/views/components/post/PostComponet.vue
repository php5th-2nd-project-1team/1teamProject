<template>
    <div class="post-local">
        <!-- 왼쪽 화살표 -->
        <img class="post-local-arrow" src="/developImg/arrow_left.png" alt="">
        <!-- 상단 지역 카테고리 -->
        <div class="post-local-item">
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
        </div>
        <!-- 오른쪽 화살표 -->
        <img class="post-local-arrow" src="/developImg/arrow_right.png" alt="">
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

</script>

<style scoped>
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