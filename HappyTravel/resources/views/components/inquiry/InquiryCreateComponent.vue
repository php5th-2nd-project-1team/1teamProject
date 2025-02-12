<template>
	<div class="cont">
		<h1>문의사항 작성</h1>
		<div style="display: flex; justify-content: flex-start; gap: 10px;">
			<label for="secret">비밀글 여부</label>
			<input type="checkbox" id="secret" @change="onClickIsSecret" :checked="isSecret">
		</div>
		<label>제목 <br> <input class="write-input" type="text" v-model="inquiryData.inquiry_title"> </label>
		<div>
			<!-- 스마트에디터가 적용될 textarea -->
			<label>내용 <br> <textarea id="editor" class="write-input"></textarea> </label>
			<div class="button-wrap">
				<button @click="cancelPost">취소</button>
				<button @click="submitInquiry">저장</button>
			</div>
		</div>
	</div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';

	const store = useStore();
	const isSecret = ref(false);
	const inquiryData = reactive({
		inquiry_title: '',
		inquiry_content: '',
		inquiry_secret: isSecret.value === true ? 1 : 0,
	});

	const onClickIsSecret = () => {
		isSecret.value = !isSecret.value;
		inquiryData.inquiry_secret = isSecret.value === true ? 1 : 0;
	}

// 컴포넌트가 마운트되면 스마트에디터 초기화
	let oEditors = ref([]);

	onMounted(() => {
		nhn.husky.EZCreator.createInIFrame({
			oAppRef: oEditors,
			elPlaceHolder: "editor",  // textarea ID
			sSkinURI: "/smarteditor3/SmartEditor2Skin.html", // 스마트에디터 스킨 경로
			fCreator: "createSEditor2",  // 스마트에디터 초기화 함수
		});
	});

	// 문의게시글 작성 처리
	const submitInquiry = () => {

		oEditors.getById['editor'].exec('UPDATE_CONTENTS_FIELD', []);

		// 스마트에디터에서 내용 추출
		inquiryData.inquiry_content = document.getElementById('editor').value;

		// store.dispatch('inquiry/createInquiry', inquiryData);
		
		console.log(inquiryData.inquiry_secret);
	}

	// 취소
	const cancelPost = () => {
		router.back();
	};


</script>

<style scoped>
	.cont {
		padding: 0 362px;
		display: flex;
		flex-direction: column;
		gap: 10px;
		
		justify-content: center;
	}

	.write-input {
		width: 99%;
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
		width:99%;
		height: 600px;
	}
</style>
