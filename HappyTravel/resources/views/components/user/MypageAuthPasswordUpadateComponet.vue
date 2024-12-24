<template>
     <div class="mypage-container-title">
        <h1>비밀번호 변경</h1>
    </div>
    <hr>
    <div class="container">
        <div class="profile-card">
            <div class="info-group">
                <label>변경할 비밀번호</label>
                <input v-model="userInfo.password" type="password" class="info-text">
            </div>
            <div class="info-group">
                <label>비밀번호 확인</label>
                <input v-model="userInfo.passwordChk" type="password" class="info-text">
            </div>
        </div>
    </div>


    <div class="button-container">
        <button class="mypage-user-update-btn" @click="$store.dispatch('user/myPasswordUpdate', userInfo)">변경</button>
        <button type="button" @click="$router.push('/user/mypage')" class="mypage-user-update-btn">취소</button>
    </div>
</template>
<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
const id = ref(store.state.auth.userInfo.user_id);

const userInfo = reactive({
        password: '',
        passwordChk: '',
        user_id: id
    });


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
    width: 150px;
}

.info-text {
    font-size: 16px;
    width: 50%;
    color: #555;
    padding: 10px 20px ;
    border: 1px solid black;
    border-radius: 5px;
    background-color: #f1f1f1;
    font-weight: 900;
}

.info-border-none-text {
    border: 1px solid #BDBDBD;
}

.info-group p {
    margin: 0;
}

.button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.mypage-user-delete-btn {
    padding: 12px 20px;
    margin: 5px;
    font-size: 16px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-weight: 900;
}

.mypage-user-delete-btn:hover {
    background-color: rgb(250, 200, 200);
    transform: translateY(-2px);
}

.mypage-user-update-btn {
    padding: 12px 20px;
    margin: 5px;
    font-size: 16px;
    background-color: #2986FF;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-weight: 900;
}

.mypage-user-update-btn:hover {
    background-color: #CDECFF;
    transform: translateY(-2px);
}


.file-insert-btn {
    padding: 12px 20px;
    margin-left: 20px;
    font-size: 16px;
    background-color: #2986FF;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    display: inline-block;
    font-weight: 900;
}

.file-insert-btn:hover {
    background-color: #CDECFF;
    transform: translateY(-2px);
}


    
</style>