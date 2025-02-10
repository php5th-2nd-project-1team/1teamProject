<template>
	<div class="account-recover-result-container">
		<h1>아이디 찾기 결과</h1>
		<p>귀하의 아이디는 다음과 같습니다.</p>
		<p>{{ account }}</p>
		<button>로그인 페이지로</button>
		<button>비밀번호 찾기</button>
	</div>
</template>
<script setup>
	import { computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
	import { useStore } from 'vuex';

	const route = useRoute();
	const router = useRouter();
	const store = useStore();

	onMounted(() => {
		if(!route.query.token || !route.query.email){
			router.push('/login');
			return;
		}

		const data = route.query;

		store.dispatch('auth/checkAccountEmail', data);
	});

	const account = computed(() => {
		return store.state.auth.findingAccount;
	});
</script>

<style scoped>

</style>