<template>
	<div class="admin-create-container">
		<h1>관리자 생성</h1>
		<div class="admin-create-buttonArea">
			<button @click="addForm">생성하기</button>
			<button @click="deleteAllForm">전체삭제하기</button>
		</div>
		<div class="admin-create-form" v-for="(form, index) in forms" :key="index">
			<label for="account">계정 : </label>
			<input type="text" id="account" v-model="form.account">
			<br>
			<label for="password">비밀번호 : </label>
			<input type="password" id="password" v-model="form.password">
			<br>
			<label for="nickname">닉네임 : </label>
			<input type="text" id="nickname" v-model="form.nickname">
			<br>
			<br>
			<button @click="deleteForm(index)">삭제하기</button>
		</div>
		<div class="admin-create-insertButtonArea">
			<button @click="createAdmin">관리자 등록하기</button>
		</div>
	</div>
</template>
<script setup>
import { reactive } from 'vue';

	const form = {	
		account : '',
		password : '',
		nickname : ''
	}

	const forms = reactive([]);

	function addForm(){
		forms.push({...form});
	}

	function deleteForm(index){
		forms.splice(index, 1);
	}
	function deleteAllForm(){
		forms.length = 0;
	}
	function createAdmin(){
		console.log(forms);
	}
</script>
<style scoped>
	.admin-create-container{
		display: flex;
		flex-direction: column;
		gap : 1rem;

		padding: 1rem;
		min-height: 100%;
	}
	.admin-create-form{
		border : 1px solid #000000;
		padding: 1rem;

		border-radius: 1rem;	
	}
	.admin-create-buttonArea{
		display: flex;
		gap: 1rem;
	}
	.admin-create-insertButtonArea button{
		padding: 0.5rem;
	}
	button{
		padding: 0.5rem;
	}
</style>