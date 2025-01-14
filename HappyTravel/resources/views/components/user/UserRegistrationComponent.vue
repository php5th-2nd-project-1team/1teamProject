<template>
    <div class="registration-container">
        <h1 class="registration-title">회원가입</h1>
        <span class="registration-making">
            <span class="span-color" style="position: relative;">*
                <div class="profile-imgArea" :style="{ backgroundImage: 'url(' + form.profile + ')' }">
                    <span class="profile-imgArea-child">프로필 사진</span>
                </div>
            </span> 필수입력사항
        </span>
        <hr>

        <!-- 아이디 -->
        <div class="registration-grid">
            <span class="span-content">아이디 <span class="span-color">*</span></span>
            <div class="id-container">
                <p v-if="errors.account" class="error-message">{{ errors.account }}</p>
                <div class="id-box-container">
                    <div style="width: 650px;">
                        <input
                            type="text"
                            v-model="form.account"
                            @input="validateAccount"
                            placeholder="6자 이상의 영문 혹은 영문과 숫자를 조합"
                            class="input-box id-box"
                        />
                        <button @click="$store.dispatch('auth/userIdCheck', form)" class="duplication-btn">중복확인</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 비밀번호 -->
        <div class="registration-grid">
            <span class="span-content">비밀번호 <span class="span-color">*</span></span>
            <div  class="id-box-container">
                <p v-if="errors.password" class="error-message">{{ errors.password }}</p>
                <input
                    type="password"
                    v-model="form.password"
                    @input="validatePassword"
                    placeholder="비밀번호는 5자 이상 20자 이하, 숫자, 영문 대소문자, 특수 문자(!, @)만 사용 가능합니다."
                    class="input-box"
                />
            </div>
        </div>

        <!-- 비밀번호 확인 -->
        <div class="registration-grid">
            <span class="span-content">비밀번호 확인 <span class="span-color">*</span></span>
            <div  class="id-box-container">
                <p v-if="errors.passwordChk" class="error-message">{{ errors.passwordChk }}</p>
                <input
                    type="password"
                    v-model="form.passwordChk"
                    @input="validatePasswordChk"
                    placeholder="비밀번호를 한 번 더 입력해주세요."
                    class="input-box"
                />
            </div>
        </div>

        <div class="registration-grid">
            <span class="span-content">프로필 사진</span>
            <label for="file" class="profile-btn">프로필 사진 선택</label>
            <input @change="setFile" type="file" name="file" accept="image/*" id="file" style="display: none;">
        </div>

        <!-- 이름 -->
        <div class="registration-grid">
            <span class="span-content">성함 <span class="span-color">*</span></span>
            <div  class="id-box-container">
            <p v-if="errors.name" class="error-message">{{ errors.name }}</p>
                <input
                    type="text"
                    v-model="form.name"
                    @input="validateName"
                    placeholder="이름은 한글로 1글자에서 20글자 사이로 입력해주세요."
                    class="input-box"
                />
            </div>
        </div>

        <!-- 이메일 -->
        <div class="registration-grid">
            <span class="span-content">이메일 <span class="span-color">*</span></span>
            <div class="id-container">
                <p v-if="errors.email" class="error-message">{{ errors.email }}</p>
                <div class="id-box-container">
                    <div style="width: 650px;">
                        <input
                            type="text"
                            v-model="form.email"
                            @input="validateEmail"
                            placeholder="이메일을 입력해주세요"
                            class="input-box id-box"
                        />
                        <button v-if="isTimerRunning" @click="startTimer" class="duplication-btn" style="cursor: none; border: none;"><span class="span-color">{{`${formattedTime}`}}</span></button>
                        <button v-else @click="userEmail" class="duplication-btn">인증번호 받기</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="emailFlg" class="registration-grid">
            <span class="span-content">인증번호 <span class="span-color">*</span></span>
            <div class="id-container">
                <div class="id-box-container">
                    <div style="width: 650px;">
                        <input
                            type="text"
                            v-model="form.code"
                            placeholder="인증번호를 입력해주세요"
                            class="input-box id-box"
                        />
                        <button @click="$store.dispatch('auth/userVerificationCode', {email: form.email, code: form.code})" class="duplication-btn">인증번호 확인</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 닉네임 -->
        <div class="registration-grid">
            <span class="span-content">닉네임 <span class="span-color">*</span></span>
            <div  class="id-box-container">
                <p v-if="errors.nickname" class="error-message">{{ errors.nickname }}</p>
                <input
                    type="text"
                    v-model="form.nickname"
                    @input="validateNickname"
                    placeholder="닉네임은 영어, 숫자, 한글만 가능하며 3자 이상 8자 이하로 입력 해주세요."
                    class="input-box"
                />
            </div>
        </div>

        <!-- 휴대폰 -->
        <div class="registration-grid">
            <span class="span-content">휴대폰 <span class="span-color">*</span></span>
            <div  class="id-box-container">
                <p v-if="errors.phone_number" class="error-message">{{ errors.phone_number }}</p>
                <input
                    type="text"
                    v-model="form.phone_number"
                    @input="validatePhoneNumber"
                    placeholder="전화번호는 010-0000-0000 형식으로 입력해야 합니다."
                    class="input-box"
                />
            </div>
        </div>

        <div class="registration-grid">
            <span class="span-content">주소 <span class="span-color">*</span></span>
            <button @click="openAddressSearch" class="address-btn">주소 검색</button>
        </div>
        <div v-if="addressFlg" class="address-container"> 
            <div class="registration-grid-adress"> 
                <label class="span-content">우편번호 <span class="span-color">*</span></label>
                <input type="text" v-model="form.zonecode" placeholder="우편번호" readonly class="input-box-address">
            </div>
            <div class="registration-grid-adress"> 
                <label class="span-content">주소 <span class="span-color">*</span></label>
                <input type="text" v-model="form.address" placeholder="주소" readonly class="input-box-address">
            </div>
            <div class="registration-grid-adress">
                <label class="span-content">상세 주소 <span class="span-color">*</span></label>
                <div class="id-box-container">
                    <input
                    type="text"
                    v-model="form.detail_address"
                    placeholder="상세 주소 입력"
                    class="input-box-address">
                </div>
            </div>
        </div>    

        <!-- 성별 -->
        <div class="registration-grid">
            <span class="span-content">성별 <span class="span-color">*</span></span>
            <div  class="id-box-container">
                <p v-if="errors.gender" class="error-message">{{ errors.gender }}</p>
                <div class="id-container gender-gap">
                    <div>
                        <input v-model="form.gender" type="radio" name="gender" value="0" @change="validateGender"> 남
                    </div>
                    <div>
                        <input v-model="form.gender" type="radio" name="gender" value="1" @change="validateGender"> 여
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="insert-container">
        <button class="insert-btn" @click="handleSubmit">가입하기</button>
    </div>
</template>
<script setup>

import { reactive, onMounted, ref, watch, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
    
    // 데이터 객체
    const form = reactive({
        account: '',        // 아이디
        password: '',       // 비밀번호
        passwordChk: '',    // 비밀번호 확인
        name: '',           // 이름
        nickname: '',       // 닉네임
        phone_number: '',   // 전화번호
        file: null,         // 프로필 사진
        zonecode: '',       // 우편번호 
        address: '',        // 기본 주소
        detail_address: '',  // 상세 주소
        gender: '',         // 성별
        email: '',
        code: '',
        profile: '/profile/default.png',
    });

    const errors = reactive({
        account: '',
        password: '',
        passwordChk: '',
        name: '',
        nickname: '',
        phone_number: '',
        gender: '',
        detail_address: '',
        email: '',
    });

    const timeLeft = ref(0); // 남은 시간(초)
    const timer = ref(null); // 타이머를 관리하는 변수

    // 타이머 실행 상태
    const isTimerRunning = computed(() => timeLeft.value > 0);

    // "분:초" 형식으로 변환된 시간
    const formattedTime = computed(() => {
        const minutes = Math.floor(timeLeft.value / 60);
        const seconds = timeLeft.value % 60;
        return `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
    });

    let emailFlg = ref(false);

    // 타이머 시작 함수
    const startTimer = async () => {
        if (isTimerRunning.value) return; // 이미 타이머 실행 중이면 종료
        timeLeft.value = 300; // 5분 (300초)

        timer.value = setInterval(() => {
            if (timeLeft.value > 0) {
            timeLeft.value--; // 매 초마다 감소
            } else {
            clearInterval(timer.value); // 타이머 종료
            timer.value = null;
            }
        }, 1000);
    };

    const userEmail = async () => {
        await store.dispatch('auth/userEmailChk', {email: form.email});
        emailFlg.value = true;
        startTimer();
    }

    // 유효성 검사 메서드
    function validateAccount() {
        const regex = /^[a-zA-Z0-9]{6,}$/;
        if (!form.account) {
            errors.account = '아이디를 입력해주세요.';
        } else if (!regex.test(form.account)) {
            errors.account = '아이디는 6자 이상의 영문 또는 숫자 조합이어야 합니다.';
        } else {
            errors.account = '';
        }
    }

    function validatePassword() {
        const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!])[A-Za-z\d@!]{5,20}$/;
        if (!form.password) {
            errors.password = '비밀번호를 입력해주세요.';
        } else if (!regex.test(form.password)) {
            errors.password = '비밀번호는 5자 이상 20자 이하, 숫자, 영문 대소문자, 특수문자(@, !)를 포함해야 합니다.';
        } else {
            errors.password = '';
        }
    }

    function validatePasswordChk() {
        if (!form.passwordChk) {
            errors.passwordChk = '비밀번호 확인을 입력해주세요.';
        } else if (form.passwordChk !== form.password) {
            errors.passwordChk = '비밀번호가 일치하지 않습니다.';
        } else {
            errors.passwordChk = '';
        }
    }

    function validateName() {
        const regex = /^[가-힣]{1,20}$/u;
        if (!form.name) {
            errors.name = '이름을 입력해주세요.';
        } else if (!regex.test(form.name)) {
            errors.name = '이름은 한글로 1자에서 20자 사이어야 합니다.';
        } else {
            errors.name = '';
        }
    }

    function validateNickname() {
        const regex = /^[a-zA-Z0-9가-힣]{3,8}$/u;
        if (!form.nickname) {
            errors.nickname = '닉네임을 입력해주세요.';
        } else if (!regex.test(form.nickname)) {
            errors.nickname = '닉네임은 영어, 숫자, 한글만 가능하며 최대 8자까지 가능합니다.';
        } else {
            errors.nickname = '';
        }
    }

    function validatePhoneNumber() {
    const rawPhone = form.phone_number.replace(/[^0-9]/g, ''); // 숫자만 남기기
    let formattedPhone = '';

        if (rawPhone.length <= 3) {
            formattedPhone = rawPhone; // 3자리 이하일 경우 하이픈 없음
        } else if (rawPhone.length <= 7) {
            // 4~7자리: 010-0000 형식
            formattedPhone = rawPhone.replace(/(\d{3})(\d{1,4})/, '$1-$2');
        } else if (rawPhone.length <= 10) {
            // 8~10자리: 010-0000-0000 형식
            formattedPhone = rawPhone.replace(/(\d{3})(\d{4})(\d{1,4})/, '$1-$2-$3');
        } else {
            // 11자리 이상: 010-0000-0000 형식
            formattedPhone = rawPhone.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
        }

        form.phone_number = formattedPhone;

        // 유효성 검사
        const regex = /^010-\d{4}-\d{4}$/;
        if (!form.phone_number) {
            errors.phone_number = '전화번호를 입력해주세요.';
        } else if (!regex.test(form.phone_number)) {
            errors.phone_number = '전화번호는 010-0000-0000 형식으로 입력해야 합니다.';
        } else {
            errors.phone_number = '';
        }
    }

    function validateGender() {
        if (!form.gender) {
            errors.gender = '성별을 선택해주세요.';
        } else {
            errors.gender = '';
        }
    }

    function validateEmail() {
        const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!form.email) {
            errors.email = '이메일을 입력해주세요.';
        } else if (!regex.test(form.email)) {
            errors.email = '유효한 이메일 형식이 아닙니다.';
        } else {
            errors.email = '';
        }
    }

    // watch 설정
    watch(() => form.account, validateAccount);
    watch(() => form.password, validatePassword);
    watch(() => form.passwordChk, validatePasswordChk);
    watch(() => form.name, validateName);
    watch(() => form.nickname, validateNickname);
    watch(() => form.phone_number, validatePhoneNumber);
    watch(() => form.gender, validateGender);
    watch(() => form.email, validateEmail);

    function handleSubmit() {
        
        const hasError = Object.values(errors).some(error => error);
        if (hasError) {
            alert('회원가입 정보를 확인해주세요.');
            return;
        }

        store.dispatch('auth/userRegistration', form);
    }

    const setFile = (e) => {
        form.file = e.target.files[0];
        form.profile = URL.createObjectURL(form.file);
    }

    let addressFlg = ref(false);
    
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
                form.zonecode = data.zonecode;      // 우편번호
                form.address = data.roadAddress;    // 도로명 주소
                addressFlg.value = true;
            },
        
        }).open();
    };
    
    // 컴포넌트가 마운트될 때 스크립트 로드
    onMounted(async () => {
        await loadDaumPostcodeScript();
    });

</script>
  
<style scoped>

    .error-message {
        color: red;
        font-size: 0.7rem;
        margin-bottom: 2px;
        position: absolute;
        bottom: 36px; /* 위치를 에러 메시지가 다른 요소와 겹치지 않도록 */
        /* margin-left: 80px; */
    }

    
    .registration-container {
        display: flex;
        flex-direction: column;
        text-align: center;
        /* justify-content: center; */
        /* align-items: center; */
        padding: 0 5%;
    }
    
    .span-content {
        align-self: center;
        line-height: 16px;
    }

    .registration-title {
        margin-bottom: 100px;
        font-size: 2.5rem;
    }

    .registration-making {
        text-align: right;
        margin-right: 10%;
        font-size: 0.6rem;
    }

    .profile-btn {
        width: 45%;
        height: 40px;
        padding-top: 6px;
        border: 2px solid black;
        background-color: white;
        font-size: 1rem;
        font-weight: 900;
        cursor: pointer;

    }

    .duplication-btn {
        width: 17%;
        height: 40px;
        border: 2px solid black;
        background-color: white;
        font-size: 1rem;
        font-weight: 900;
        cursor: pointer;
    }
    
    .span-color {
        color: red;
    }

    hr {
        width: 80%;
        margin: 0 auto;
        border: 1px solid black;
    }

    .registration-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        margin-top: 40px;
        font-size: 0.9rem;
        font-weight: 900;
        position: relative; /* 추가: 자식 요소들에 영향을 미치지 않도록 */
    }
    
    .input-box {
        padding: 10px;
        width: 45%;
        border: 2px solid rgba(0, 0, 0, 0.25);
    }

    .id-container{
        width: 100%;
        padding : 0;
        display: flex;
        gap : 0.5rem;
        text-align: left;
    }

    .id-box-container {
        display: flex;
    }

    .id-box {
        width: 510px;
    }

    .gender-gap {
        gap: 30px;
    }


    .address-btn {
        width: 45%;
        height: 40px;
        border: 2px solid black;
        background-color: white;
        font-size: 1rem;
        font-weight: 900;
        cursor: pointer;
    }
    
    .input-box-address {
        padding: 10px;
        width: 80%;
        border: 2px solid rgba(0, 0, 0, 0.25);
    }

    .registration-grid-adress {
        display: grid;
        grid-template-columns: 0.3fr 0.7fr;
        margin: 20px;
        font-size: 0.9rem;
        font-weight: 900;
    }

    .address-container {
        width: 46%;
        margin: 0 auto;
        margin-top: 40px;
        background-color: #F3F3F3;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .insert-container {
        margin-top: 100px;
        text-align: center;
    }

    .insert-btn {
        font-size: 2.5rem;
        width: 30%;
        height: 80px;
        border: none;
        color: white;
        background-color: #2986FF;
        border-radius: 40px;
        cursor: pointer;
    }

    /* 원상 수정 */
    .profile-imgArea{
        position: absolute;

        width: 180px;
        height: 180px;
        border: 1px solid black;
        border-radius: 50%;

        left: -100px;
        top: 40px;

        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .profile-imgArea-child{
        position: absolute;
        left: 32px;
        top: 190px;

        color: black;
        font-size: 1.2rem;
        font-weight: 900;

        border: 2px solid black;
        padding: 5px;
    }
</style>