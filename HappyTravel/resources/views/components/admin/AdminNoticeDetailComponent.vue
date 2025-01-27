<template>
	<div class="admin-notice-detail-container">
		<h1>공지사항 상세</h1>
		<div>
			<p> id : <span>1</span></p>
		</div>
		<div>
			<label for="important">중요</label>
			<input type="checkbox" id="important" name="important" value="true" disabled>
		</div>
		<div>
			<p>제목 : <span>제목</span></p>
		</div>
		<div>
			<p>작성자 : <span>작성자</span></p>
		</div>
		<div>
			<p>작성일자 : <span>2025-01-01</span></p>
		</div>
		<div>
			<p>내용</p>
			<br>
			<div style="border: 1px solid #000; padding: 1rem;">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio eius dicta id saepe. Quidem soluta eum, repellendus assumenda optio dicta. Quasi illum quas laudantium tempora in cumque dolore fuga est!
			</div>
		</div>
		<div class="admin-notice-detail-button-group">
			<button>수정</button>
			<button>삭제</button>
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