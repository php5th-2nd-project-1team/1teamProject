<template>   
    <div v-if="loadingFlg" class="loading-title">로딩중</div>
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
                        <img :src="detailUserInfo.profile">
                    </div>
                    <div>
                        <label for="file">
                            <div class="file-insert-btn">프로필 수정</div>
                        </label>
                    </div>
                    <input @change="setFile" type="file" name="profile" accept="image/*" id="file" style="display: none">
                </div>
                <div class="mypage-detail">
                    <div class="mypage-name">
                        <div class="mypage-name-title">
                            <p class="mypage-all-title">성함</p>
                            <input v-model="detailUserInfo.name" type="text" class="mypage-name-border">
                        </div>
                        <div class="mypage-nickname">
                            <p class="mypage-all-title">닉네임</p>
                            <input v-model="detailUserInfo.nickname" type="text" class="mypage-nickname-border">
                        </div>
                    </div>

                    <div class="mypage-number">
                        <p class="mypage-all-title">전화번호</p>
                        <input v-model="detailUserInfo.phone_number" type="text" class="mypage-number-border">
                    </div>

                    <div class="registration-grid">
                        </div>
                        <div class="address-container">
                            <div class="registration-grid"> 
                                <p class="mypage-all-title">우편번호</p>
                                <input type="text" v-model="detailUserInfo.post_code" placeholder="우편번호" readonly class="mypage-name-border">
                            </div>
                            <div class="mypage-adress"> 
                                <p class="mypage-all-title">주소</p>
                                <input type="text" v-model="detailUserInfo.address" placeholder="주소" readonly class="mypage-adress-border">
                            </div>
                            <div class="registration-grid">
                                <p class="mypage-all-title">상세 주소</p>
                                <input type="text" v-model="detailUserInfo.detail_address" placeholder="상세 주소 입력" class="mypage-adress-border">
                            </div>

                            <button @click="openAddressSearch" class="address-btn">주소 수정</button>
                        </div>    
                </div>
            </div>
            <hr class="footer-hr">
            <div class="footer-title">
                <button class="mypage-user-update-btn" @click="$store.dispatch('user/myPageUpdate', detailUserInfo)">수정</button>
                <button class="mypage-user-delete-btn" @click="router.push('/passwordcheck')">회원 탈퇴</button>
            </div>
        </div>
    </div>


    <router-view></router-view>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();
const id = ref(store.state.auth.userInfo.user_id);

const loadingFlg = computed(() => store.state.user.loadingFlg);

const detailUserInfo = store.state.auth.userInfo;

const setFile = (e) => {
    detailUserInfo.file = e.target.files[0];
    detailUserInfo.profile = URL.createObjectURL(detailUserInfo.file);
}

// 스크립트를 동적으로 로드하는 함수
const loadDaumPostcodeScript = () => {
        return new Promise((resolve) => {
        const scriptId = "daum-postcode-script";
        if (document.getElementById(scriptId)) {
            return resolve(); // 이미 스크립트가 로드된 경우
        }
    
        // html 코드에 script 코드를 동적으로 요소를 넣어주는 역할
        const script = document.createElement("script");
        script.id = scriptId;
        script.src = "https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js";
        script.onload = () => resolve();
        document.head.appendChild(script);
        });
    };
    
    // 주소 검색 팝업을 여는 함수
    const openAddressSearch = () => {
        if (!window.daum || !window.daum.Postcode) {
        alert("카카오 주소 API가 아직 로드되지 않았습니다.");
        return;
        }
    
        new window.daum.Postcode({
            oncomplete: (data) => {
                detailUserInfo.zonecode = data.post_code;      // 우편번호
                detailUserInfo.address = data.address;    // 도로명 주소
            },
        
        }).open();
    };
    // 컴포넌트가 마운트될 때 스크립트 로드
    onMounted(async () => {
        await loadDaumPostcodeScript();
    });
    

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
    height: 620px;

    
    display: flex;
    justify-content: center;
    align-items: center;
}

.mypage-border {
    margin-top: 100px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 70%;
    height: 105%;
}

    
.mypage-title {
    display: flex;
    justify-content: space-between;
    padding: 15px;
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

.mypage-name {
    display: flex;
    justify-content: space-between;
}

.mypage-name-title {
    width: 100%;
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
    width: 50%;
}

.mypage-nickname-border {
    border: none;
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
    /* background-size: cover;
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

.file-insert-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1rem;
    margin-top: 20px;
    padding: 20px;
    width: 100%;
    height: 40px;
    cursor: pointer;
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
    border: none;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 20%;
}

.mypage-number-border {
    background-color: #EFEFEF;
    border: none;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 30%;
}

.mypage-adress-border {
    background-color: #EFEFEF;
    border: none;   
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

.footer-title {
    display: flex;
    justify-content: space-between;
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

.mypage-user-delete-btn {
    background-color: #FF5353;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 20px;
    width: 15%;
    height: 55px;
    margin-right: 15px;
}

.mypage-user-delete-btn:hover {
    background-color: white;
    border: 3px solid #FF5353;
    color: black;
}

.address-btn {
    background-color: #35e625;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1rem;
    margin-top: 20px;
    padding: 5px;  
    width: 30%;
    height: 40px;
    cursor: pointer;
}
</style>