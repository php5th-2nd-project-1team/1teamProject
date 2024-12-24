<template>
     <div class="mypage-container-title">
        <h1>내 정보</h1>
        <router-link to="/"><button class="home-btn">홈으로</button></router-link>
    </div>
    <hr>
    <div class="container">
        <div class="profile-card">
            <div class="info-group">
                <label>이름</label>
                <input v-model="detailUserInfo.name" type="text" class="info-text">
            </div>
            <div class="info-group">
                <label>닉네임</label>
                <input v-model="detailUserInfo.nickname" type="text" class="info-text">
            </div>
            <div class="info-group">
                <label>전화번호</label>
                <input v-model="detailUserInfo.phone_number" type="text" class="info-text" @input="formatPhoneNumber">
            </div>
            <div class="info-group">
                <label>우편번호</label>
                <input v-model="detailUserInfo.post_code" type="text" class="info-text info-border-none-text" readonly>
            </div>
            <div class="info-group">
                <label>주소</label>
                <input v-model="detailUserInfo.address" type="text" class="info-text info-border-none-text" readonly>
            </div>
            <div class="info-group">
                <label>상세주소</label>
                <input v-model="detailUserInfo.detail_address" type="text" class="info-text">
            </div>
        </div>
        <div>
            <label for="file">
                    <div class="file-insert-btn" for="file">프로필 수정</div>
            </label>
            <button @click="openAddressSearch" class="file-insert-btn">주소 수정</button>
        </div>
        <input @change="setFile" type="file" name="profile" accept="image/*" id="file" style="display: none">
    </div>


    <div class="button-container">
        <button class="mypage-user-update-btn" @click="$store.dispatch('user/myPageUpdate', detailUserInfo)">수정 완료</button>
        <button class="mypage-user-delete-btn" @click="router.push('/user/passwordcheck?flg=1')">회원 탈퇴</button>
    </div>
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

const formatPhoneNumber = (e) => {
        detailUserInfo.phone_number = e.target.value.replace(/[^0-9]/g, '');

        if (detailUserInfo.phone_number.length < 4) {
        // 4자리 미만은 하이픈 없이 입력
        detailUserInfo.phone_number = detailUserInfo.phone_number;

        } else if (detailUserInfo.phone_number.length < 7) {
            // 4자리에서 6자리까지는 3-4자리 형태로 하이픈 추가
            detailUserInfo.phone_number = detailUserInfo.phone_number.replace(/(\d{3})(\d{1,4})/, '$1-$2');
        } else if (detailUserInfo.phone_number.length < 11) {
            // 7자리에서 10자리까지는 3-4-4자리 형태로 하이픈 추가
            detailUserInfo.phone_number = detailUserInfo.phone_number.replace(/(\d{3})(\d{4})(\d{1,4})/, '$1-$2-$3');
        } else {
            // 11자리 이상은 3-4-4자리 형태로 하이픈 추가
            detailUserInfo.phone_number = detailUserInfo.phone_number.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
        }

        // 추가 조건: 7자리가 되었을 때 하이픈이 다시 생기지 않도록 방지
        if (detailUserInfo.phone_number.length === 7 && detailUserInfo.phone_number.indexOf('-') !== 3) {
        // 하이픈이 3번째 자리에 없으면, 강제로 추가
        detailUserInfo.phone_number = detailUserInfo.phone_number.replace(/(\d{3})(\d{1,4})/, '$1-$2');
        };
    };

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
                detailUserInfo.post_code = data.zonecode;      // 우편번호
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