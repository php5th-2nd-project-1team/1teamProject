<template>
    <div class="shopDetail-container">
        <ShopDetailInfoComponent/>
        <div v-html="shopBoardDetail.class_content"></div>
    </div>
</template>
<script setup>
    import ShopDetailInfoComponent from './shop_detail/ShopDetailInfoComponent.vue';   
    import { computed } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();

    // const src = function(id){
    //     return '/developImg/shop_detail'+id+'.png';
    // }


    const shopBoardDetail = computed(() => store.state.shop.shopBoardDetail);
    
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
    .shopDetail-img{
        width: 100%;
    }
</style>