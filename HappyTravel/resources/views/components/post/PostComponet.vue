<template>
    <div class="post-local">
        <img class="post-local-arrow" src="../../../../public/developImg/arrow_left.png" alt="">
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <div class="post-local-item">
            <img class="post-local-item-img" src="../../../../public/developImg/seoul_icon.png" alt="">
            <p>서울</p>
        </div>
        <img class="post-local-arrow" src="../../../../public/developImg/seoul_icon.png" alt="">
    </div>
    <div class="post-search">
        <div class="post-search-bg">
            <h3>#관광지 검색</h3>
            <input class="post-search-box" type="search" name="search" placeholder="검색어를 입력해주세요.">
            <button class="btn btn-bg-blue btn-search" type="button">검색</button>
        </div>
    </div>
    <div class="post-all">
        <div class="post-content">
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
                <h3>순천 조례호수공원</h3>
            </div>
            <div class="post-content-card">
                <img class="post-content-card-img" src="../../../../public/developImg/post-content-img.png" alt="">
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
}

.post-content-card-img:hover {
    background-image: linear-gradient(to bottom, rgba(0,0,0,0) 5%,rgba(255,255,255,1) 90%);
    transform: translateY(0);
    transition: 0.5s;
}

.btn-post-more {
    width: 200px;
    
}

</style>