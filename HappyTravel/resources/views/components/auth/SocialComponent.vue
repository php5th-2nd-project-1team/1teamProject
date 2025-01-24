<template>
    <LoadingComponent />
</template>
<script setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';
import LoadingComponent from '../utilities/LoadingComponent.vue'
const store = useStore();
onMounted(() => {
    store.dispatch('auth/socialLoginInfo');
});
</script>
<style>
</style>