<template>
<div class="container" style="display: flex; flex-direction: column; justify-content: space-between; height: 100vh;">
    <HeaderComponent v-if="!isAdminPage"/>
    <!-- main -->
    <main>
        <div>
            <router-view></router-view>
        </div>
    </main>
    <FooterComponent v-if="!isAdminPage"/>
</div>
</template>
    
<script setup>
import { useRoute } from 'vue-router';
import FooterComponent from './utilities/FooterComponent.vue';
import HeaderComponent from './utilities/HeaderComponent.vue';
import { computed } from 'vue';

const route = useRoute();

const isAdminPage = computed(() => {
    return route.path.startsWith('/admin');
});

</script>
<style>
    @import url('../../css/common.css');
</style>