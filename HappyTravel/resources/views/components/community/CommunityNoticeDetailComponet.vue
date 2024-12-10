<template>
    <div class="community_notice_detail_container">
        <h1>공지사항</h1> 
    <!-- 공지사항 태그 박스 -->
        <div class="notice_tag_detail_box">
            <div class="notice_tag_detail_number">
                <p>번호</p>
            </div>
            <div class="notice_tag_detail_manager">
                <p>관리자</p>
            </div>
            <div class="notice_tag_detail_date">
                <p>작성일자</p>
            </div>
        </div>
        <div class="notice_content_detail_box">
            <p>제목</p>
            <textarea placeholder="내용을 입력해주세요." maxlength="75"></textarea>
        </div>   
        <div class="notice_content_detail_box">
            <p>내용</p>
            <textarea placeholder="내용을 입력해주세요." maxlength="75"></textarea>
        </div> 
    </div>      
</template>

<script setup>

</script>

<style scoped>
      h1 { 
        margin: 20px;
    }
    .notice_tag_detail_box {
    display: grid; 
    grid-template-columns:repeat(3,1fr);
    justify-content: space-around;
    gap:10px;
    border-top : 1px solid black;
    border-bottom : 1px solid black;
    padding: 20px; 
    margin:20px;  
    font-size: 1.5rem;
    font-weight: 300;
    color: #2986FF;
    }
    .notice_content_detail_box {
        display: grid;
        grid-template-columns: 40px 1fr;
        margin:20px;
    }
    .notice_content_detail_box > p{
        margin-top:25px;
       
    }
    .notice_content_detail_box > textarea {
        width:100%;
        min-height:40px;
        padding:20px;
        background-color: #EFEFEF;
        resize:none;
        overflow: hidden;
    }
    .notice_content_detail_box > textarea {
        width:100%;
        min-height:200px;
        padding:20px;
        background-color: #EFEFEF;
        resize:none;
        overflow: hidden;
    }
</style>