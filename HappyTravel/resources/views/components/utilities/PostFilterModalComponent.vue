<template>
<!-- 포스트 필터 모달 -->
<div class="modal-box">
    <div class="modal-content">
        <h2 class="title">필터</h2>
        <div class="filter-container">
            <h3>반려동물</h3>
            <div class="pet-type">
                <div>
                    <input type="checkbox" id="sDog" name="sDog">
                    <label for="sDog">소형견</label>
                </div>
                <div>
                    <input type="checkbox" id="mDog" name="mDog">
                    <label for="mDog">중형견</label>
                </div>
                <div>
                    <input type="checkbox" id="lDog" name="lDog">
                    <label for="lDog">대형견</label>
                </div>
                <div>
                    <input type="checkbox" id="cat" name="cat">
                    <label for="cat">고양이</label>
                </div>
                <div>
                    <input type="checkbox" id="bird" name="bird">
                    <label for="bird">조류</label>
                </div>
            </div>
        </div>
        <div class="filter-container">
            <h3>반려동물 편의</h3>
            <div class="pet-option">
                <div>
                    <input type="checkbox" id="dry-room" name="dry-room">
                    <label for="dry-room">드라이룸</label>
                </div>
                <div>
                    <input type="checkbox" id="pool" name="pool">
                    <label for="pool">애견수영장</label>
                </div>
                <div>
                    <input type="checkbox" id="playroom" name="playroom">
                    <label for="playroom">애견놀이터</label>
                </div>
                <div>
                    <input type="checkbox" id="grass" name="grass">
                    <label for="grass">잔디마당</label>
                </div>
                <div>
                    <input type="checkbox" id="menu" name="menu">
                    <label for="menu">반려동물 메뉴</label>
                </div>
            </div>
        </div>
        <div class="btn-delete">
            <img class="reset-icon" src="/developImg/reset.png" alt="">
            <span>전체 해제</span>
        </div>
        <div class="btn-filter">
            <button class="btn btn-header btn-bg-blue">적용</button>
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
    cursor: pointer;
}

.btn-delete:hover {
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