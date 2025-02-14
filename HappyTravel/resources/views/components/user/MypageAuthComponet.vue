<template>
    <div class="mypage-container-title">
        <h1>내 정보</h1>
    </div>
    <hr>
    <div class="container">
        <div class="profile-card">
            <div class="info-group">
                <label>이름</label>
                <span class="info-text">{{ allUserInfo.name }}</span>
            </div>
            <div class="info-group">
                <label>닉네임</label>
                <span class="info-text">{{ allUserInfo.nickname }}</span>
            </div>
            <div class="info-group">
                <label>전화번호</label>
                <span class="info-text">{{ allUserInfo.phone_number }}</span>
            </div>
            <div class="info-group">
                <label>우편번호</label>
                <span class="info-text">{{ allUserInfo.post_code }}</span>
            </div>
            <div class="info-group">
                <label>주소</label>
                <span class="info-text">{{ allUserInfo.address }}</span>
            </div>
            <div class="info-group">
                <label>상세주소</label>
                <span class="info-text">{{ allUserInfo.detail_address }}</span>
            </div>
        </div>
    </div>

    <div class="button-container">
        <router-link to="/user/passwordcheck?flg=0"><button>정보 수정</button></router-link>
        <button @click="$router.push('/')">홈으로</button>
    </div>
</template>
<script setup>
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { computed } from 'vue';

const store = useStore();
const router = useRouter();

const allUserInfo = computed(() => store.state.auth.userInfo);

</script>
<style scoped>

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

h1 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

hr {
    margin-bottom: 10px;
    border: 2px solid #BDBDBD;
}

.profile-card {
    display: flex;
    flex-direction: column;
    padding: 30px;
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
    
</style>