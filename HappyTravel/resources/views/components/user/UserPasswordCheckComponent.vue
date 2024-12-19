<template>
    <div class="PasswordCheck-container">
        <div class="PasswordCheck-border">
            <h1 class="pet-breeze-title">Pet Breeze</h1>
            <hr>
            <div class="PasswordCheck-main">
                <label for="password" class="password-title">본인 확인을 위해 비밀번호를 입력해주세요.</label>
                <br>
                <input v-model="userInfo.password" type="password" id="password" class="password-box">
            </div>
            <hr>
            <div class="btn-div">
                <button @click="$store.dispatch('user/userPasswordChk', userInfo)" v-if="previusPath === '/user/mypage'" class="clear-btn">회원수정</button>
                <button v-else-if="previusPath === '/mypage/auth/update'" class="delete-btn" @click="$store.dispatch('user/userDelete', id)" >회원탈퇴</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import router from '../../../js/router';
import { useStore } from 'vuex';

const store = useStore();

const id = computed(() => store.state.auth.userInfo.user_id);

const previusPath = ref(router.options.history.state.back);

const user_id = ref(store.state.auth.userInfo.user_id);

const userInfo = reactive({
        password: ''
        ,user_id: user_id
    });


</script>

<style scoped>
button {
    cursor: pointer;
}

.PasswordCheck-container {
    width: 100%;
    height: 550px;
    
    display: flex;
    justify-content: center;
    align-items: center;
}

.PasswordCheck-border {
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 70%;
    height: 95%;
}

.pet-breeze-title {
    font-size: 4rem;
    padding: 15px
}

.PasswordCheck-main {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 12vh;
    margin-bottom: 12vh;
}

.password-title {
    font-size: 1.7rem;
    font-weight: 900;
}

.password-box {
    width: 55%;
    font-size: 2rem;
    padding: 10px;
    border-radius: 5px;
    background-color: #EFEFEF;
    border: none;
}

hr {
    width: 100%;
    border-color: rgba(0, 0, 0, 0.2);
}

.btn-div {
    text-align: right;
}

.clear-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1.5rem;
    width: 15%;
    padding: 15px;
    margin-top: 2vh;
    margin-right: 2vh;
}

.clear-btn:hover {
    background-color: white;
    border: 3px solid #2986FF;
    color: black;
}

.delete-btn {
    /* display: none; */
    border: none;
    background-color: #FF5353;
    border-radius: 10px;
    color: white;
    font-size: 1.5rem;
    width: 15%;
    padding: 15px;
    margin-top: 2vh;
    margin-right: 2vh;
}

.delete-btn:hover {
    background-color: white;
    border: 3px solid #FF5353;
    color: black;
}
</style>