<template>
	<div class="admin-notice-detail-container">
		<h1>공지사항 수정</h1>
		<div>
			<label for="id">id : </label>
			<input type="text" id="id" >
		</div>
		<div>
			<label for="important">중요</label>
			<input type="checkbox" id="important" name="important" value="true">
		</div>
		<div>
			<label for="title">제목 : </label>
			<input type="text" id="title" value="제목">
		</div>
		<div>
			<label for="content">내용</label>
			<br>
			<!-- TODO 나중에 스마트에디터로 변경할 것 -->
			<textarea id="content" name="content" cols="30" rows="10"></textarea>
		</div>
		<div class="admin-notice-create-button-group">
			<button>작성</button>
			<button>미리보기</button>
			<button>목록</button>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.admin-notice-detail-container{
		width: 100%;
		height: 100%;

		display: flex;
		flex-direction: column;

		padding : 1rem;

		gap : 1rem;
	}
</style>