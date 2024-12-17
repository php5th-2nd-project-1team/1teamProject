<template>   
    <LoadingComponent v-if="loadingFlg" />
    <div v-else class="mypage-container">
        <div class="mypage-border">
            <div class="mypage-title">
                <h1>마이페이지</h1>
               <button @click="router.push('/index')" class="mypage-back-btn">홈으로</button>
            </div>
            <hr class="title-hr">
            <div class="mypage-main">
                <div class="mypage-profile">
                    <div class="profile">
                        <img :src="allUserInfo.profile">
                    </div>
                </div>
                <div class="mypage-detail">
                    <div class="mypage-name">
                        <div class="mypage-name-title">
                            <p class="mypage-all-title">성함</p>
                            <p class="mypage-name-border">{{ allUserInfo.name }}</p>
                        </div>
                        <div class="mypage-nickname">
                            <p class="mypage-all-title">닉네임</p>
                            <p class="mypage-nickname-border">{{ allUserInfo.nickname }}</p>
                        </div>
                    </div>

                    <div class="mypage-number">
                        <p class="mypage-all-title">전화번호</p>
                        <p class="mypage-number-border">{{ allUserInfo.phone_number }}</p>
                    </div>

                    <div class="mypage-adress">
                        <p class="mypage-all-title">주소</p>
                        <p class="mypage-adress-border">{{ allUserInfo.address }}</p>
                    </div>
                    
                    <div class="mypage-adress-detail">
                        <p class="mypage-all-title">상세주소</p>
                        <p class="mypage-adress-detail-border">{{ allUserInfo.detail_address }}</p>
                    </div>
                </div>
            </div>
            <hr class="footer-hr">
            <div class="footer-title">
                <router-link  to="/passwordcheck"><button class="mypage-user-update-btn">회원정보 수정</button></router-link>
            </div>
        </div>
    </div>


    <router-view></router-view>
</template>

<script setup>
import LoadingComponent from '../utilities/LoadingComponent.vue'
import { computed, onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
const id = ref(store.state.auth.userInfo.user_id);

const loadingFlg = computed(() => store.state.user.loadingFlg);

onBeforeMount(() => store.dispatch('user/userDetailPage', id.value));

const allUserInfo = store.state.auth.userInfo;

</script>

<style scoped> 
button {
    cursor: pointer;
}

.loading-title {
    width: 100%;
    height: 100%;
    background-color: #2986FF;
    color: white;
    font-size: 4rem;
    text-align: center;
}

.mypage-container {
    width: 100%;
    height: 600px;

    
    display: flex;
    justify-content: center;
    align-items: center;
}

.mypage-border {
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 60%;
    height: 85%;
}

    
.mypage-title {
    display: flex;
    justify-content: space-between;
    padding: 15px;
}

.mypage-name {
    display: flex;
    justify-content: space-between;
}


.mypage-name-title {
    width: 100%;
}

.mypage-back-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 20px;
    width: 15%;
    height: 55px;
}

.mypage-back-btn:hover {
    background-color: white;
    border: 3px solid #2986FF;
    color: black;
}

.mypage-main {
    display: grid;
    grid-template-columns: 0.3fr 0.7fr;
}

.mypage-detail {
    line-height: 2rem;
}

.title-hr {
   width: 100%;
   margin-bottom: 40px;
   border-color: rgba(0, 0, 0, 0.2);
}

.mypage-all-title {
    font-size: 10px;
    font-weight: 900;
}

.mypage-nickname {
    width: 30%;
    margin-right: 30px
}

.mypage-nickname-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
}

.mypage-profile {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.profile {
    /* background-image: url('../../../../public/developImg/about-three1.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat; */
    width: 180px;
    height: 180px;
    border: 1px solid black;
    border-radius: 50%;
}

.profile > img {
    width: 180px;
    height: 180px;
    border: none;
    border-radius: 50%;
}

.mypage-update-btn {
    background-color: #EFEFEF;
    border: none;
    border-radius: 10px;
    width: 50px;
    height: 30px;
    margin-right: 20px;
}

.mypage-delete-btn {
    background-color: #EFEFEF;
    border: none;
    border-radius: 10px;
    width: 50px;
    height: 30px;
}

.mypage-name-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 20%;
}

.mypage-number-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 30%;
}

.mypage-adress-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 80%;
}

.mypage-adress-detail-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 80%;
}

.footer-hr {
    width: 100%;
    margin-top: 40px;
    margin-bottom: 20px;
    border-color: rgba(0, 0, 0, 0.2);
}

.mypage-user-update-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 20px;
    width: 15%;
    height: 55px;
    margin-left: 15px;
}

.mypage-user-update-btn:hover {
    background-color: white;
    border: 3px solid #2986FF;
    color: black;
}

</style>