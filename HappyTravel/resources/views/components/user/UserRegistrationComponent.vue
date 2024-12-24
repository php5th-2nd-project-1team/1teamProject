<template>
    <div class="registration-container">
        <h1 class="registration-title" >회원가입</h1>
        <span class="registration-making"><span class="span-color" style="position: relative;">*<div class="profile-imgArea" :style="{backgroundImage: 'url('+ form.profile +')'}"><span class="profile-imgArea-child">프로필 사진</span></div></span> 필수입력사항</span>
        <hr>
        <div class="registration-grid">
            <span class="span-content">아이디 <span class="span-color">*</span></span>
            <div class="id-container">
                <input type="text" v-model="form.account" placeholder="6자 이상의 영문 혹은 영문과 숫자를 조합" class="input-box id-box"> 
                <button @click="$store.dispatch('auth/userIdCheck', form)" class="duplication-btn">중복확인</button>
            </div>
        </div>
        <div class="registration-grid">
            <span class="span-content">비밀번호 <span class="span-color">*</span></span>
            <input type="password" v-model="form.password" placeholder="비밀번호는 5자 이상 20자 이하, 숫자, 영문 대소문자, 특수 문자(!, @)만 사용 가능합니다." class="input-box">
        </div>
        <div class="registration-grid">
            <span class="span-content">비밀번호 확인 <span class="span-color">*</span></span>
            <input type="password"  v-model="form.passwordChk" placeholder="비밀번호를 한 번 더 입력해주세요." class="input-box">
        </div>
        <div class="registration-grid">
            <span class="span-content">프로필 사진</span>
            <label for="file" class="profile-btn">프로필 사진 선택</label>
            <input @change="setFile" type="file" name="file" accept="image/*" id="file" style="display: none;">
        </div>
        <div class="registration-grid">
            <span class="span-content">성함 <span class="span-color">*</span></span>
            <input type="text" v-model="form.name" placeholder="이름은 한글로 2글자에서 4글자 사이로 입력해주세요." class="input-box">
        </div>
        <div class="registration-grid">
            <span class="span-content">닉네임 <span class="span-color">*</span></span>
            <input type="text" v-model="form.nickname" placeholder="닉네임은 영어, 숫자, 한글만 가능하며 최대 8자리까지 입력 해주세요." class="input-box">
        </div>
        <div class="registration-grid">
            <span>휴대폰 <span class="span-color">*</span></span>
            <input type="text" @input="formatPhoneNumber" v-model="form.phone_number" placeholder="전화번호는 010-0000-0000 형식으로 입력해야 합니다." class="input-box">
        </div>
        <!-- 카카오 주소 검색 api --------------------------------------------------- -->
        <!-- 주소 검색 버튼 -->
        <!-- v-if="!addressFlg" -->
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
                <input type="text" v-model="form.detail_address" placeholder="상세 주소 입력" class="input-box-address">
            </div>
        </div>    
        <!-- 카카오 주소 검색 api --------------------------------------------------- -->
        <div class="registration-grid">
            <span class="span-content">성별 <span class="span-color">*</span></span>
            <div class="id-container gender-gap">
                <div>
                    <input v-model="form.gender"type="radio" name="gender" value="0"> 남
                </div>
                <div>
                    <input v-model="form.gender" type="radio" name="gender" value="1"> 여
                </div>
            </div>
        </div>
    </div>
    <div class="insert-container">
        <button class="insert-btn" @click="$store.dispatch('auth/userRegistration', form)">가입하기</button>
    </div>

  </template>
<script setup>

import { reactive, onMounted, ref } from "vue";
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
        profile: '/profile/default.png',
    });

    const setFile = (e) => {
        form.file = e.target.files[0];
        form.profile = URL.createObjectURL(form.file);
    }

    let addressFlg = ref(false);

    const formatPhoneNumber = (e) => {
        form.phone_number = e.target.value.replace(/[^0-9]/g, '');

        if (form.phone_number.length < 4) {
        // 4자리 미만은 하이픈 없이 입력
        form.phone_number = form.phone_number;

        } else if (form.phone_number.length < 7) {
            // 4자리에서 6자리까지는 3-4자리 형태로 하이픈 추가
            form.phone_number = form.phone_number.replace(/(\d{3})(\d{1,4})/, '$1-$2');
        } else if (form.phone_number.length < 11) {
            // 7자리에서 10자리까지는 3-4-4자리 형태로 하이픈 추가
            form.phone_number = form.phone_number.replace(/(\d{3})(\d{4})(\d{1,4})/, '$1-$2-$3');
        } else {
            // 11자리 이상은 3-4-4자리 형태로 하이픈 추가
            form.phone_number = form.phone_number.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
        }

        // 추가 조건: 7자리가 되었을 때 하이픈이 다시 생기지 않도록 방지
        if (form.phone_number.length === 7 && form.phone_number.indexOf('-') !== 3) {
        // 하이픈이 3번째 자리에 없으면, 강제로 추가
        form.phone_number = form.phone_number.replace(/(\d{3})(\d{1,4})/, '$1-$2');
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

    .span-content {
        align-self: center;
        line-height: 16px;
    }
    
    .registration-container {
        display: flex;
        flex-direction: column;
        text-align: center;
        /* justify-content: center; */
        /* align-items: center; */
        padding: 0 5%;
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
        width: 30%;
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
        grid-template-columns: 0.3fr 0.7fr;
        margin-left: 100px;
        margin-top: 30px;
        /* margin: 1.5%; */
        font-size: 0.9rem;
        font-weight: 900;
    }
    
    .input-box {
        padding: 10px;
        width: 45%;
        border: 2px solid rgba(0, 0, 0, 0.25);
    }

    .id-container{
        width: 51%;
        padding : 0;
        display: flex;
        gap : 0.5rem;
        text-align: left;
    }

    .gender-gap {
        gap: 30px;
    }

    .id-box{
        width: 100%;
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