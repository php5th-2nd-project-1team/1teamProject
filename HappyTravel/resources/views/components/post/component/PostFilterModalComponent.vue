<template>
<!-- 포스트 필터 모달 -->
<div class="modal-box">
    <div class="modal-content">
        <h2 class="title">필터</h2>
        <div class="filter-container">
            <h3>반려동물</h3>
            <div class="pet-type">
                <div>
                    <input type="checkbox" id="sDog" value="01" v-model="filters.animalType">
                    <label for="sDog">소형견</label>
                </div>
                <div>
                    <input type="checkbox" id="mDog" value="02" v-model="filters.animalType">
                    <label for="mDog">중형견</label>
                </div>
                <div>
                    <input type="checkbox" id="lDog" value="03" v-model="filters.animalType">
                    <label for="lDog">대형견</label>
                </div>
                <div>
                    <input type="checkbox" id="cat" value="04" v-model="filters.animalType">
                    <label for="cat">고양이</label>
                </div>
                <div>
                    <input type="checkbox" id="bird" value="05" v-model="filters.animalType">
                    <label for="bird">조류</label>
                </div>
            </div>
        </div>
        <div class="filter-container">
            <h3>반려동물 편의</h3>
            <div class="pet-option">
                <div>
                    <input type="checkbox" id="dry-room" value="02" v-model="filters.facilityType">
                    <label for="dry-room">드라이룸</label>
                </div>
                <div>
                    <input type="checkbox" id="pool" value="03" v-model="filters.facilityType">
                    <label for="pool">애견수영장</label>
                </div>
                <div>
                    <input type="checkbox" id="playroom" value="04" v-model="filters.facilityType">
                    <label for="playroom">애견놀이터</label>
                </div>
                <div>
                    <input type="checkbox" id="grass" value="05" v-model="filters.facilityType">
                    <label for="grass">잔디마당</label>
                </div>
                <div>
                    <input type="checkbox" id="menu" value="01" v-model="filters.facilityType">
                    <label for="menu">반려동물 메뉴</label>
                </div>
            </div>
        </div>
        <div class="btn-delete">
            <img class="reset-icon" src="/developImg/reset.png" alt="">
            <span class="btn-reset" @click="resetFilter">전체 해제</span>
        </div>
        <div class="btn-filter">
            <button class="btn btn-header btn-bg-blue" @click="setFilters">적용</button>
            <button @click="closeFilterModal" class="btn btn-header btn-bg-gray">닫기</button>
        </div>
    </div>
</div>
</template>
<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const emit = defineEmits();
const filters = reactive({
    animalType: []
    ,facilityType: []
});

const setFilters = () => {
    // console.log('A:', filters.animalType);
    // console.log('F:', filters.facilityType);
    store.dispatch('post/index', {
        animalType: filters.animalType
        ,facilityType : filters.facilityType
    });
    closeFilterModal();
};

const closeFilterModal = () => {
    emit('postFilterClose');
}

// 전체 해제
const resetFilter = () => {
    filters.animalType = [];
    filters.facilityType = [];
    // setFilters();
};



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
    width: 30%;
    background-color: #fff;
    padding: 30px;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    /* align-items: center; */
    /* justify-content: center; */
}

.title {
    padding: 10px;
    margin-bottom: 10px;
    border-bottom: 1px solid #cacaca;
}

.btn-filter {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pet-type {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    width: 500px;
    padding: 10px;
}

.pet-option {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 10px;
    padding: 10px;
}

.filter-container {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    margin-right: 30px;
}

.btn-delete {
    display: flex;
    justify-content: flex-end;
    margin: 10px 0;
    color: #cacaca;
}

.btn-reset {
    display: inline;
    cursor: pointer;
}

.btn-reset:hover {
    color: #000;
}

.reset-icon {
    width: 20px;
    height: 20px;
    cursor: pointer;
    margin-right: 5px;

}

input {
    margin-right: 5px;
}
</style>