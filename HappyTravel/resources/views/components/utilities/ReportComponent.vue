<template>
<!-- 신고 모달 -->
<div class="modal-box">
    <div class="modal-content">
        <div class="header-container">
            <img class="report-icon" src="/developImg/report_icon.png" alt="">
            <h3 class="title">클릭하여 신고사유를 선택해 주세요.</h3>
        </div>
        <div class="report-container">
            <div class="report-box">
                <div class="report-content">
                    <input type="radio" id="01" value="01" name="report" v-model="reportData.report_code" checked>
                    <label for="01">욕설/비속어 포함</label>
                </div>
                <div class="report-content">
                    <input type="radio" id="02" value="02" name="report" v-model="reportData.report_code">
                    <label for="02">갈등 조장 및 허위사실 유포</label>
                </div>
                <div class="report-content">
                    <input type="radio" id="03" value="03" name="report" v-model="reportData.report_code">
                    <label for="03">폭력적 또는 혐오스러운 컨텐츠</label>
                </div>
                <div class="report-content">
                    <input type="radio" id="04" value="04" name="report" v-model="reportData.report_code">
                    <label for="04">도배 및 광고글</label>
                </div>
                <div class="report-content">
                    <input type="radio" id="05" value="05" name="report" v-model="reportData.report_code">
                    <label for="05">기타</label>
                </div>

            </div>
            <textarea v-model="reportData.report_text" class="report-text" minlength="1" maxlength="200" cols="100" placeholder="기타 추가할 내용을 적어주세요."></textarea>
        </div>
        <div class="btn-filter">
            <button class="btn btn-header btn-bg-red" @click="applyReport">신고</button>
            <button @click="closeReportModal"  class="btn btn-header btn-bg-gray">닫기</button>
        </div>
    </div>
</div>
</template>
<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';
// import store from '../../../js/store/store';
import { defineProps } from 'vue';
// comment_id 프롭스
const props = defineProps({
    'commentId' : Number,
});

const store = useStore();
const emit = defineEmits();
const reportData = reactive({
    report_category: '01'
    ,report_board_id: 0
    ,report_code: ''
    ,report_text: ''
});

const closeReportModal = () => {
    emit('postReportClose');
    reportData.report_text = '';
    reportData.report_code = '';
};

const applyReport = () => { 
    try {
        // reactive안에서 실시간 데이터변환이 되지 않음 신고버튼누를시 commentId를 가져옴
        reportData.report_board_id = props.commentId;
        store.dispatch('report/reportComment', reportData);
        // console.log(reportData.report_category);
        // console.log(reportData.report_board_id);
        console.log(reportData.report_code);
        console.log(reportData.report_text);
    } catch (error) {
        console.error("Error in handleClick:", error);
    }
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
    margin-bottom: 10px;
    border-bottom: 1px solid #cacaca;
    margin-left: 10px;
    width: 100%;
}

.btn-filter {
    display: flex;
    justify-content: center;
    align-items: center;
}

.report-box {
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

.report-container {
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

.btn-bg-red {
    background-color: #FF5353;
    color: #fff;
}

.btn-bg-red:hover {
    background-color: #fff;
    color: #000;
    box-shadow: 0 0 0 2px #FF5353 inset;
    transition: 0.1s ease-out;
}

.report-icon {
    width: 25px;
    height: 25px;
}

.header-container {
    display: flex;
}

.report-content {
    margin-bottom: 10px;
}

.report-text {
    border: 1px solid#b3b3b3;
    height: 90px;
    margin-bottom: 20px;
    resize: none;
    padding: 5px;
}
</style>