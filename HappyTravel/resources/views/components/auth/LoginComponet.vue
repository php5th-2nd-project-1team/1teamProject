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
                    <input v-model="userInfo.password" type="password" name="password" class="login-main">
                </div>
                <button @click="$store.dispatch('auth/login', userInfo)">로그인</button>
            </div>
        </div>
        <div class="login-password-regist">

        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue';


    const userInfo = reactive({
        account: ''
        ,password: ''
    });

</script>
<style scoped>

    * {
        margin: 0px;
        padding: 0px;
    }

    /* 로그인 컨테이너 */
    .login-container{
        width: 100%;
        height: 600px;
        
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

    .login-title button{
        margin-top: 20px;
        margin-bottom: 30px;
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

    .login-title button:hover {
        background-color: white;
        border: 3px solid #2986FF;
        color: black;
    }

    .login-title input{
        padding-left: 10px;
        border: none;
        outline: none;
        width: 100%;
        font-size: 30px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .login-guidebook {
        padding-left: 10px;
    }
</style>