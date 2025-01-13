<template>
<!-- 포스트 필터 모달 -->
<div class="modal-box">
    <div class="modal-content">
        <h2>반려동물 정보</h2>
        <h3>반려동물</h3>
        <div class="pet-type">
            <input type="checkbox" id="sDog" name="sDog">
            <label for="sDog">소형견</label>
            <input type="checkbox" id="mDog" name="mDog">
            <label for="mDog">중형견</label>
            <input type="checkbox" id="lDog" name="lDog">
            <label for="lDog">대형견</label>
            <input type="checkbox" id="cat" name="cat">
            <label for="cat">고양이</label>
            <input type="checkbox" id="bird" name="bird">
            <label for="bird">조류</label>
        </div>
        <h3>몸무게</h3>
        <h3>반려동물 시설</h3>
        <div class="pet-option">
            <input type="checkbox">
            <label for="">드라이룸</label>
            <input type="checkbox">
            <label for="">실내수영장</label>
            <input type="checkbox">
            <label for="">애견수영장</label>
            <input type="checkbox">
            <label for="">애견놀이터</label>
            <input type="checkbox">
            <label for="">잔디마당</label>
        </div>
        <div class="btn-filter">
            <button class="btn btn-header btn-bg-blue">확인</button>
            <button @click="$emit('postFilterClose')" class="btn btn-header btn-bg-gray">닫기</button>
        </div>
    </div>
</div>
</template>
<script setup>

</script>
<style scoped>
   .modal-box {
    position: fixed;
    display: flex;
    align-items: center;
    justify-content: center;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    width: 100vw;
    height: 100vh;
    z-index: 10000;
}

.modal-content {
    width: 40%;
    background-color: #fff;
    padding: 20px;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.btn-filter {
    display: flex;
    justify-content: space-around;
    margin-top: 10px;
}

.pet-type {
    display: flex;
    justify-content: space-around;
    gap: 10px;
}

.pet-option {
    display: flex;
    justify-content: space-around;
    gap: 20px;
}
</style>