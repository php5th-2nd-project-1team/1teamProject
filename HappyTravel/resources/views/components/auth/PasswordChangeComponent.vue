<template>
	<LoadingComponent v-if="loadingFlg" />
    <div v-else>
        <h2 v-if="tokenValid">비밀번호 변경</h2>
        <h2 v-else>유효하지 않은 요청</h2>
        <form v-if="tokenValid" @submit.prevent="resetPassword">
                <input v-model="password" type="password" placeholder="새 비밀번호" required />
                <input v-model="passwordConfirm" type="password" placeholder="비밀번호 확인" required />
                <button type="submit">변경하기</button>
        </form>
        <p v-if="resetMessage">{{ resetMessage }}</p>
    </div>
  </template>
  
  <script setup>
  import LoadingComponent from "../utilities/LoadingComponent.vue";
  import { ref, computed, onMounted } from "vue";
  import { useStore } from "vuex";
  import { useRoute } from "vue-router";
  
  const store = useStore();
  const route = useRoute();
  
  const password = ref("");
  const passwordConfirm = ref("");

  const loadingFlg = computed(() => store.state.auth.loadingFlg);
  
  const tokenValid = computed(() => store.state.auth.tokenValid);
  const resetMessage = computed(() => store.state.auth.resetMessage);
  
  onMounted(() => {
      const { token, email } = route.query;
      if (token && email) {
          store.dispatch("auth/verifyResetToken", { token, email });
      } else {
          store.commit("auth/setTokenValid", false);
          store.commit("auth/setResetMessage", "잘못된 접근입니다.");
      }
  });
  
  function resetPassword() {
      if (!password.value || !passwordConfirm.value) {
          store.commit("auth/setResetMessage", "비밀번호를 입력하세요.");
          return;
      }
  
      if (password.value !== passwordConfirm.value) {
          store.commit("auth/setResetMessage", "비밀번호가 일치하지 않습니다.");
          return;
      }
  
      const { token, email } = route.query;
  
      store.dispatch("auth/resetPassword", {
          email,
          token,
          password: password.value,
          password_confirmation: passwordConfirm.value
      })
  }
  </script>