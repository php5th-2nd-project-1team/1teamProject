<template >
	<div class="account-recover-container">
		<h1>아이디 찾기</h1>
		<label for="name">이름 : <input type="text" id="name" v-model="userInfo.account" /></label>
		<label for="email">이메일 : <input type="email" id="email" v-model="userInfo.email" /></label>
		<button @click="findId" v-if="!isSendingCode">아이디 찾기</button>
		<p>{{ accountMessage }}</p>
	</div>
</template>
<script setup>
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex';
	const store = useStore();
	const userInfo = reactive({
		account: '',
		email: ''
	})

	const findId = () => {
		if(userInfo.account.trim() === '' || userInfo.email.trim() === '') {
			alert('이름과 이메일을 입력해주세요.');
			return;
		}
		store.dispatch('auth/requestAccountEmail', userInfo);
	}

	const accountMessage = computed(() => {
		return store.state.auth.accountMessage;
	})
	const isSendingCode = ref(false);
</script>
<style scoped>

	.account-recover-container {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		width: 100%;

		padding : 0 360px;
	}
</style>