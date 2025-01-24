<template>
    <LoadingComponent v-if="LoadingFlg" />
    <div class="shop-container">
        <h1>예약</h1>
        <ShopCalanderComponent/>
        <ShopCardAreaComponent/>
    </div>
</template>

<script setup>
    import LoadingComponent from '../utilities/LoadingComponent.vue';
    import ShopCalanderComponent from './shop_board/ShopCalanderComponent.vue';
    import ShopCardAreaComponent from './shop_board/ShopCardAreaComponent.vue';
    import { computed } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();

    
	const LoadingFlg = computed(() => store.state.shop.LoadingFlg);
</script>

<style scoped>
    .shop-container{
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