<template>
    <h1>로그인중</h1>
</template>
<script setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';
const store = useStore();
onMounted(() => {
    store.dispatch('auth/socialLoginInfo');
});
</script>
<style>
</style>