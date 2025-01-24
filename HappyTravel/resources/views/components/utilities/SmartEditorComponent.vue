<template>
    <div>
      <input v-model="EditorValue.title" type="text">
      <!-- 스마트에디터가 적용될 textarea -->
      <textarea id="editor" name="editor"></textarea>
      <button @click="submitContent">저장</button>
    </div>
  </template>
  
  <script setup>
  // Vue 3 Composition API에서 제공하는 ref와 onMounted를 사용
  import { ref, onMounted, reactive, defineProps } from 'vue';
  import { useStore } from "vuex";
  
  const props = defineProps({
    dispatch : String
  });

  const oEditors = ref([]);  // 스마트에디터 객체를 저장할 변수

  const store = useStore();
  
  const EditorValue = reactive({
      title: "",
      content: ""
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
      EditorValue.content = editorContent;

      // Vuex에 저장
      store.dispatch(props.dispatch , EditorValue);
      // console.log(props.dispatch);
  };

  </script>
  
  <style scoped>
  
  #editor {
      width: 100%; /* 원하는 넓이로 조정 */
      height: 600px; /* 원하는 높이로 조정 */
  }
  
  </style>