<template>
	<div class="admin-login-container">
		<h1>관리자 로그인</h1>
		<div>
			<label for="id">id : </label>
			<input type="text" id="id" >
		</div>
		<div>
			<label for="password">password : </label>
			<input type="password" id="password" >
		</div>
		<button>로그인</button>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.admin-login-container{
		width: 100%;
		height: 100%;

		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;

		gap: 1rem;
		padding: 1rem;
	}

	.admin-login-container div{
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		justify-content: center;

		gap: 0.5rem;
	}
</style>