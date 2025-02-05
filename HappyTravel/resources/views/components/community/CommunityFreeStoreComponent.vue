<template>
    <div>
      <h1>자유게시판 글쓰기</h1>        
  
      <div class="FreeStoreContainer">
        <div class="select-wrap">
          <select v-model="selectBoard" class="select-box">
            <option value="0">자유게시판</option>
            <option value="1">자랑게시판</option>
            <option value="2">문의게시판</option>
          </select>
        </div>
        
        <input type="text" v-model="title" placeholder="제목" maxlength="50">
        
        <!-- 스마트에디터 컴포넌트 -->
        <SmartEditorComponent :dispatch="FreeBoardStore" /> 
  
        <div class="button-container">
          <button @click="cancelPost">취소</button>
          <button>작성완료</button>
        </div>       
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';   
  import SmartEditorComponent from '../utilities/SmartEditorComponent.vue';
  
  const selectBoard = ref('0');
  const title = ref('');
  const FreeBoardStore = 'editor/FreeBoardStore';
  
  // 취소
  const cancelPost = () => {
    if (confirm('작성을 취소하시겠습니까?')) {
      window.history.back();
    }
  };
  
  
  </script>
  
  <style scoped>
  .FreeStoreContainer {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .select-wrap {
    margin-bottom: 10px;
  }
  
  .select-box {
    width: 100%;
    padding: 8px;
  }
  
  input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .button-container {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
  }
  
  button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  button:first-child {
    background-color: #ccc;
  }
  
  button:last-child {
    background-color: #007bff;
    color: white;
  }
  </style>
  