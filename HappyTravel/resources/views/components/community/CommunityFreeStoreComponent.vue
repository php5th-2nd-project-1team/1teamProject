<template>
    <div class="cont">
      <h1>글쓰기</h1>        
  
      <div class="FreeStoreContainer">
        <div class="select-wrap">
          <select v-model="editorValue.community_type" class="select-box">
            <option value="0">자유게시판</option>
            <option value="1">자랑게시판</option>
            <option value="2">문의게시판</option>
          </select>
        </div>
        
      <div>
        <input v-model="editorValue.title" type="text">
        <!-- 스마트에디터가 적용될 textarea -->
        <textarea id="editor" name="editor"></textarea>
        <div class="button-wrap">
          <button @click="cancelPost">취소</button>
          <button @click="submitContent">저장</button>
        </div>
      </div>
      
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, reactive, defineProps, computed } from 'vue';
  import { useStore } from "vuex";
  import router from '../../../js/router.js';
  
  const oEditors = ref([]);  // 스마트에디터 객체를 저장할 변수

  const store = useStore();

  const userInfo = computed(() => store.state.auth.userInfo.user_id);
  
  const editorValue = reactive({
      title: '',
      content: "",
      userId: userInfo,
      community_type: '0'
  });
  
  // 컴포넌트가 마운트되면 스마트에디터 초기화
  onMounted(() => {
    nhn.husky.EZCreator.createInIFrame({
      oAppRef: oEditors,
      elPlaceHolder: "editor",  // textarea ID
      sSkinURI: "/smarteditor3/SmartEditor2Skin.html", // 스마트에디터 스킨 경로
      fCreator: "createSEditor2",  // 스마트에디터 초기화 함수
    });
  });

  const submitContent = async () => {
        oEditors.getById['editor'].exec('UPDATE_CONTENTS_FIELD', []);

        // 스마트에디터에서 내용 추출
        const editorContent = document.getElementById('editor').value;

        // content 값을 reactive 객체에 업데이트
        editorValue.content = editorContent;
      console.log(editorValue);
        // Vuex에 저장
        store.dispatch('boards/freeBoardStore' , editorValue);
        // console.log(props.dispatch);
    };
  
  // 취소
  const cancelPost = () => {
    router.back();
  };
  
  
  </script>
  
  <style scoped>
  .cont {
    padding: 0 362px;
  }
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
    border: 1px solid #EFEFEF;
    border-radius: 4px;
  }

  button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    background-color: #2986FF;
    color: white;
    cursor: pointer;
  }
  .button-wrap  {
    display: flex;
    justify-content: flex-end;
    margin-top: 50px;
    gap: 10px;
  }
 
  #editor {
    width:100%;
    height: 600px;
  }
  </style>
  