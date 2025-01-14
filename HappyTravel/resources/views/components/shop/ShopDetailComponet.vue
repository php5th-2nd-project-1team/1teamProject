<template>
    <div class="shopDetail-container">
        <ShopDetailInfoComponent/>
        <img :src=src(i) alt="" class="shopDetail-img" v-for="i in 10" :key="i">
    </div>
</template>
<script setup>
    import ShopDetailInfoComponent from './shop_detail/ShopDetailInfoComponent.vue';    
    const src = function(id){
        return '/developImg/shop_detail'+id+'.png';
    }
</script>
<style scoped>
    .shopDetail-container{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        max-width: 1200px;

        margin: auto;

        gap : 2rem;
    }
</style>