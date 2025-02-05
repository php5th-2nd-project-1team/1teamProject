<template>
    <div>
      <h2>비밀번호 찾기</h2>
      <form @submit.prevent="handlePasswordReset">
        <input v-model="passwordReset.email" type="email" placeholder="이메일을 입력해주세요" required />
        <input v-model="passwordReset.name" type="text" placeholder="성함을 입력해주세요" required />
        <button type="submit" :disabled="loading">비밀번호 재설정</button>
      </form>
      <p v-if="resetMessage">{{ resetMessage }}</p>
    </div>
  </template>
  
  <script setup>
  import { reactive, computed } from "vue";
  import { useStore } from "vuex";
  
  const store = useStore();
  const passwordReset = reactive({
              email: '',
              name: '',
  });
  
  const loading = computed(() => store.state.auth.loadingFlg);
  
  const resetMessage = computed(() => store.state.auth.resetMessage);
  
  function handlePasswordReset() {
      if (!passwordReset.email) {
        store.commit("auth/setResetMessage", "이메일을 입력해주세요.");
        return;
      }else if(!passwordReset.name) {
        store.commit("auth/setResetMessage", "성함을 입력해주세요.");
        return;
      }
  
      store.dispatch("auth/requestPasswordReset", passwordReset);
  }
  </script>