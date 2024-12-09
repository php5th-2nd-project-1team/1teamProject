<template>
   <h1>공지사항</h1> 
   <!-- 공지사항 태그 박스 -->
   <div class="notice_tag_box">
      <div class="notice_number">
         <p>번호</p>
      </div>
      <div class="notice_title">
         <p>제목</p>
      </div>  <div class="notice_maager">
         <p>작성자</p>
      </div>
      <div class="notice_number">
         <p>작성일자</p>
      </div>      
   </div>    
   <div class="notice_content_box">

   </div>
</template>

<script setup>
</script>

<style scoped>
   h1 { 
      margin-bottom: 20px;
   }
  .notice_tag_box {
   display: flex;
   flex-direction: row;
   justify-content: space-around;
   margin: 20px;
   color: #0F77FF;
  }
  .notice_content_box {
   background-color: #E8E8FF;
   width:200px;
   height: 200px;
  }
  
</style>