<template>
	<div>
		
	</div>
</template>
<script setup>
import { computed, watch } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

// 함수들은 동일...
// 수정 시 
function create(){
	console.log('create');
}

// 삽입 시
function edit(id){
	console.log('edit');
}

// 조회 시
function show(id){
	console.log('show');
}

const postData = computed(() => {
	return data;
});

// 라우트 변경 감지
watch(
	() => route.path,
	(path) => {
		const id = route.params.id;
		
		if (path.includes('/admin/posts/create')) {
			create();
		} else if (path.includes('/admin/posts/edit/')) {
			edit(id);
		} else if (path.includes('/admin/posts/')) {
			show(id);
		}
	},
	{ immediate: true }
);
</script>
<style scoped>
	
</style>