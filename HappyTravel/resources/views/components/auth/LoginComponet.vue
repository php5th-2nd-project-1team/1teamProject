<template>
    <div class="login-container">
        <div class="login-border">
            <div class="login-title">
                <h1 class="title">Pet Breeze</h1>
                <div class="input-id-box">
                    <p class="login-guidebook">아이디</p>
                    <input v-model="userInfo.account" type="text" name="account" class="login-main">
                </div>
                <div class="input-password-box">
                    <p class="login-guidebook">비밀번호</p>
                    <input v-model="userInfo.password" type="password" name="password" class="login-main" @keyup.enter="onLogin()">
                </div>
                <button class="login-btn" @click="onLogin()">로그인</button>
                <button class="kakao-login" @click="loginWith('kakao')">
                    <img src="/developImg/kakao.png" />
                    카카오 로그인</button>
            </div>
        </div>
        <div class="login-password-regist">

        </div>
    </div>
</template>

<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();


    const userInfo = reactive({
        account: ''
        ,password: ''
    });

    const onLogin = () => {
        store.dispatch('auth/login', userInfo);
    }

    const loginWith = (provider) => {
      store.dispatch('auth/socialLogin', provider);
    };

</script>
<style scoped>

    * {
        margin: 0px;
        padding: 0px;
    }

    /* 로그인 컨테이너 */
    .login-container{
        width: 100%;
        height: 700px;
        
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* 로그인 보더 부분 */
    .login-border{
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        width: 50%;
        height: 80%;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }

    /* 로그인 타이틀 및 아래 부분 */
    .login-title{
        width: 70%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .title {
        font-size: 70px;
        padding-top: 30px;
    }

    .input-id-box{
        border: 1px solid black;
        border-radius: 5px 5px 0px 0px;
        width: 100%;
        margin-top: 80px;
    }

    .input-password-box{
        border-radius: 0px 0px 5px 5px;
        border-top: none;
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        width: 100%;
    }

    p {
        font-size: 10px;    
        margin-top: 5px;
        font-weight: 900;
    }

    .login-btn{
        margin-top: 20px;
        /* margin-bottom: 50px; */
        width: 100%;
        height: 70px;
        background-color : #2986FF;
        color: white;
        font-size: 35px;
        font-weight: 900; 

        border: none;

        border-radius: 10px;
        cursor: pointer;
    }

    .login-btn:hover {
        background-color: white;
        border: 3px solid #2986FF;
        color: black;
    }

    .login-title input{
        padding-left: 10px;
        border: none;
        outline: none;
        width: 100%;
        font-size: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .login-guidebook {
        padding-left: 10px;
    }

    .login-main {
        padding: 5px;
    }

    .kakao-login {
        margin-top: 10px;
        margin-bottom: 50px;
        width: 100%;
        height: 70px;
        background-color: #FEE500; /* 카카오 로고 색상 */
        color: #3C1E1E; /* 텍스트 색상 (카카오 브랜드 컬러) */
        color: white;
        font-size: 35px;
        font-weight: 900; 
        display: flex;
        align-items: center;
        justify-content: center;

        border: none;

        border-radius: 10px;
        cursor: pointer;
    }

    .kakao-login img {
        width: 40px; /* 이미지 크기 */
        height: 40px;
        margin-right: 10px; /* 이미지와 텍스트 간격 */
    }

    .kakao-login:hover {
        background-color: #FDD900; /* 호버 시 색상 변경 */
    }

    .kakao-login:active {
        background-color: #E0C800; /* 클릭 시 색상 */
    }
</style>