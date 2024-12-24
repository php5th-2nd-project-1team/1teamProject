<template>
    <ModalComponent v-if="modalFlg" :data="data"/>
    <div class="PasswordCheck-container">
        <div class="PasswordCheck-border">
            <h1 class="pet-breeze-title">Pet Breeze</h1>
            <div class="PasswordCheck-main">
                <label for="password" class="password-title">본인 확인을 위해 비밀번호를 입력해주세요.</label>
                <br>
                <input v-model="userInfo.password" type="password" id="password" class="password-box">
            </div>
            <div class="btn-div">
                <button @click="$store.dispatch('user/userPasswordChk', userInfo)" v-if="flg === '0'" class="clear-btn">회원수정</button>
                <!-- <button v-else-if="previusPath === '/user/mypage/update'" class="delete-btn" @click="$store.dispatch('user/userDelete', id)" >회원탈퇴</button> -->
                <button v-else-if="flg === '1'" class="delete-btn" @click="$store.dispatch('user/userDeletePasswordChk', userInfo)">회원탈퇴</button>
                <button v-else-if="flg === '2'" class="password-btn" @click="$store.dispatch('user/PasswordUpdateChk', userInfo)">비밀번호 변경</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import ModalComponent from '../utilities/ModalComponent.vue';
import { ref, reactive, computed, onMounted } from 'vue';
import router from '../../../js/router';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

const flg = ref(route.query.flg);

// const id = computed(() => store.state.auth.userInfo.user_id);

const user_id = ref(store.state.auth.userInfo.user_id);

const previusPath = ref(router.options.history.state.back);

const modalFlg = computed(() => store.state.user.modalFlg);

onMounted(()=>{
    store.commit('user/setModalFlg', false);
    if(!(flg.value === '0' || flg.value === '1' || flg.value ==='2')){
        router.push('/');
    } 
})

const userInfo = reactive({
        password: ''
        ,user_id: user_id
    });


const data = reactive({
    title : '회원 탈퇴'
    ,content : '귀하는 현재 회원 탈퇴를 하려 합니다. 동의하십니까?'
    ,warningContent : '회원 탈퇴 후 되돌릴 수 없으며, 향후 1년간 같은 아이디로 로그인을 할 수 없습니다.'
    ,onClickCancel : function(){
        store.commit('user/setModalFlg', false);
    }
    ,onClickConfirm : function(){
        store.dispatch('user/userDelete', user_id.value);
    }
});


</script>

<style scoped>
button {
    cursor: pointer;
}

.PasswordCheck-container {
    width: 100%;
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.PasswordCheck-border {
    padding-bottom: 20px;
}

.pet-breeze-title {
    font-size: 2rem;
    padding: 15px
}

.PasswordCheck-main {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 9vh;
    margin-bottom: 9vh;
}

.password-title {
    font-size: 1.3rem;
    font-weight: 900;
}

.password-box {
    width: 50%;
    font-size: 1.5rem;
    padding: 20px;
    border-radius: 5px;
    background-color: #EFEFEF;
    border: none;
}

/* hr {
    width: 100%;
    border-color: rgba(0, 0, 0, 0.2);
} */

.btn-div {
    text-align: right;
}

.clear-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1.2rem;
    width: 15%;
    padding: 15px;
    margin-top: 2vh;
    margin-right: 2vh;
    border: 3px solid #2986FF;
}

.clear-btn:hover {
    background-color: white;
    color: black;
}

.password-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1.2rem;
    width: 20%;
    padding: 15px;
    margin-top: 2vh;
    margin-right: 2vh;
    border: 3px solid #2986FF;
}

.password-btn:hover {
    background-color: white;
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
    border: 3px solid #FF5353;
}

.delete-btn:hover {
    background-color: white;
    color: black;
}
</style>