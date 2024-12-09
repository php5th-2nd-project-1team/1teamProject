<template>
<div class="container" style="display: flex; flex-direction: column; justify-content: space-between; height: 100vh;">
    <HeaderComponent/>
    <!-- main -->
    <main>
        <div>
            <router-view></router-view>
        </div>
    </main>
    <FooterComponent/>
</div>
</template>
    
<script setup>
import FooterComponent from './utilities/FooterComponent.vue';
import HeaderComponent from './utilities/HeaderComponent.vue';

 

</script>
<style>
    @import url('../../css/common.css');
</style>