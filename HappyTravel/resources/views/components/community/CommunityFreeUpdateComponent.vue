<template>
    <div class="cont">
      <h1>자유게시판 수정</h1>  
      <!-- <hr>      -->
      <!-- {{ editData }} -->
      <!-- <hr> -->
      <div class="FreeStoreContainer">
        <div>
          <input v-model="editData.community_title" type="text">
          <!-- 스마트에디터가 적용될 textarea -->
          <textarea id="editor" name="editor" v-html="editData.community_content"></textarea>
          <div class="button-wrap">
              <button @click="submitContent">수정하기</button>
            <button @click="cancelPost">취소</button>
          </div>
        </div>
      
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, reactive, computed } from 'vue';
  import { useStore } from "vuex";
  import router from '../../../js/router.js';
  import { useRoute} from 'vue-router';
  
  
  const oEditors = ref([]);  // 스마트에디터 객체를 저장할 변수

  const store = useStore();
  const route = useRoute();

  const freeDetail = computed(() => store.state.boards.freeDetail);
  
  const editData = reactive({
    community_title: freeDetail.value.community_title,
    community_content: freeDetail.value.community_content,
    community_id : freeDetail.value.community_id,
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
        
        // content 값을 reactive 객체에 업데이트
        editData.community_content =  oEditors.getById['editor'].getIR();;

        // Vuex에 저장
        store.dispatch('boards/freeBoardUpdate' , editData);
        // console.log(props.dispatch);
        router.replace(`/community/free/${route.params.id}`);        
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
  