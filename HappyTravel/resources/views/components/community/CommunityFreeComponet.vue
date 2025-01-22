<template>
    <div class="free-title-bg">
        <h1>자유게시판</h1>
    </div>
    
    <select v-model="selectOpiton">
        <option value="all">전체</option>
        <option value="content">내용</option>
        <option value="title">제목</option>
        <option value="user">글쓴이</option>
        <option value="titleContent">제목+내용</option>
    </select>    
    <input type="text" placeholder="검색어를 입력해주세요.">
    <button>검색</button>

    <div class="free-container">
      <div class="free-header">
            <div class="free-item">No.</div>
            <div class="free-item">제목</div>
            <div class="free-item">글쓴이</div>
            <div class="free-item">작성날자</div>
            <div class="free-item">조회수</div>
      </div>

      <div class="free-row">
          <div class="free-item">999.</div>
            <div class="free-item">나나나나노노노노노(121)</div>
            <div class="free-item">둘리</div>
            <div class="free-item">2025-01-22 09:01:52</div>
            <div class="free-item">15</div>
      </div>
      <div class="free-row">
          <div class="free-item">1.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">난나</div>
            <div class="free-item">2025-01-22 09:01:53</div>
            <div class="free-item">150</div>
      </div>
      <div class="free-row">
          <div class="free-item">10.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">아기</div>
            <div class="free-item">2025-01-22 09:01:54</div>
            <div class="free-item">15000</div>
      </div>
      <div class="free-row">
          <div class="free-item">999.</div>
            <div class="free-item">나나나나노노노노노(121)</div>
            <div class="free-item">둘리</div>
            <div class="free-item">2025-01-22 09:01:52</div>
            <div class="free-item">15</div>
      </div>
      <div class="free-row">
          <div class="free-item">1.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">난나</div>
            <div class="free-item">2025-01-22 09:01:53</div>
            <div class="free-item">150</div>
      </div>
      <div class="free-row">
          <div class="free-item">10.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">아기</div>
            <div class="free-item">2025-01-22 09:01:54</div>
            <div class="free-item">15000</div>
      </div>
      <div class="free-row">
          <div class="free-item">999.</div>
            <div class="free-item">나나나나노노노노노(121)</div>
            <div class="free-item">둘리</div>
            <div class="free-item">2025-01-22 09:01:52</div>
            <div class="free-item">15</div>
      </div>
      <div class="free-row">
          <div class="free-item">1.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">난나</div>
            <div class="free-item">2025-01-22 09:01:53</div>
            <div class="free-item">150</div>
      </div>
      <div class="free-row">
          <div class="free-item">10.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">아기</div>
            <div class="free-item">2025-01-22 09:01:54</div>
            <div class="free-item">15000</div>
      </div>
      <div class="free-row">
          <div class="free-item">999.</div>
            <div class="free-item">나나나나노노노노노(121)</div>
            <div class="free-item">둘리</div>
            <div class="free-item">2025-01-22 09:01:52</div>
            <div class="free-item">15</div>
      </div>
      <div class="free-row">
          <div class="free-item">1.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">난나</div>
            <div class="free-item">2025-01-22 09:01:53</div>
            <div class="free-item">150</div>
      </div>
      <div class="free-row">
          <div class="free-item">10.</div>
            <div class="free-item">나나나나노노노노노(21)</div>
            <div class="free-item">아기</div>
            <div class="free-item">2025-01-22 09:01:54</div>
            <div class="free-item">15000</div>
      </div>
    </div>


</template>
    
<script setup>
    import {ref} from 'vue';

    // 드롭다운에서 선택된 값 저장할 변수
    const selectedOption = ref('all');
    
</script>

<style scoped>
    .free-title-bg {  
        font-size: 2rem;
        padding: 15px;
        margin: 0 auto;
        width: 80%;
        text-align: center;
    }

    .free-container {
        width: 80%;
        margin: 20px 0;
        margin: 0 auto;
        margin-top: 50px;
        display: grid; /* 전체 컨테이너에 그리드 적용 */
        grid-template-columns: 1.5fr 2.5fr 2fr 1fr 1fr; /* 각 항목의 너비 설정 */
    }

    .free-header, .free-row {
        display: contents; /* 내용만 표시하고 부모 요소는 그리드 항목으로 활용 */
        background-color: #2986FF;
    }

    .free-item {
        background-color: #2986FF;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        /* border-top: 2px solid #2986FF; /* 헤더의 상단 보더 */
        border-bottom: 1px solid #2986FF; /* 각 항목 사이의 구분선 */
        
        display: flex;
        justify-content: center;
        align-items: center;

        /* 텍스트 줄 바꿈 방지 */
        white-space: nowrap;
        
        /* 너무 긴 텍스트를 잘라내고 '...' 추가 */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .free-row .free-item {
        background-color: #fff;
        color: #333;

    }

   
</style>