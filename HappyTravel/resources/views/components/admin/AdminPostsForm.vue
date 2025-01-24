<template>
	<div>
		<h1>게시글 상세</h1>
		<div>
			<label for="title">제목</label>
			<input type="text" id="title">
		</div>
		<div>
			<label for="local">지역</label>
			<select name="local" id="local">
				<option value="서울">서울</option>
				<option value="경기">경기</option>
				<option value="인천">인천</option>
				<option value="부산">부산</option>
				<option value="대구">대구</option>
				<option value="대전">대전</option>
			</select>
		</div>
		<div>
			<label for="content">테마</label>
			<select name="theme" id="theme" v-model="theme" @change="">
				<option value="01">테마1</option>
				<option value="02">테마2</option>
				<option value="03">테마3</option>
				<option value="04">테마4</option>
			</select>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	
</style>