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
            <div class="content-card">
                <div class="img-container">
                    <img class="img-like" src="/developImg/btn-delete1.png" alt="">
                    <img class="content-img" src="/img/220-main.png" alt="">
                </div>
                <h3 class="content-title">오창저수지</h3>
                <p class="content-local">충청북도 청주시</p>
            </div>
            <div class="content-card">
                <div class="img-container">
                    <img class="img-like" src="/developImg/btn-delete1.png" alt="">
                    <img class="content-img" src="/img/220-main.png" alt="">
                </div>
                <h3 class="content-title">오창저수지</h3>
                <p class="content-local">충청북도 청주시</p>
            </div>
            <div class="content-card">
                <div class="img-container">
                    <img class="img-like" src="/developImg/btn-delete1.png" alt="">
                    <img class="content-img" src="/img/220-main.png" alt="">
                </div>
                <h3 class="content-title">오창저수지</h3>
                <p class="content-local">충청북도 청주시</p>
            </div>
            <div class="content-card">
                <div class="img-container">
                    <img class="img-like" src="/developImg/btn-delete1.png" alt="">
                    <img class="content-img" src="/img/220-main.png" alt="">
                </div>
                <h3 class="content-title">오창저수지</h3>
                <p class="content-local">충청북도 청주시</p>
            </div>
            <div class="content-card">
                <div class="img-container">
                    <img class="img-like" src="/developImg/btn-delete1.png" alt="">
                    <img class="content-img" src="/img/220-main.png" alt="">
                </div>
                <h3 class="content-title">오창저수지</h3>
                <p class="content-local">충청북도 청주시</p>
            </div>
 
            <!-- <div class="content-card">
                <PostCardComponent v-for="value in wishList" :cardData="value" />
            </div> -->
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
import { computed, onMounted } from 'vue';

const store = useStore();
const router = useRouter();

// const wishList = computed(() => store.state.post.postList);

// onMounted(() => {
//     store.dispatch('post/index', true);
// })




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
</style>