<template>   
<LoadingComponent v-if="loadingFlg" />
    <div v-else class="my-page-container">
        <div class="my-page-sidebar">
            <div class="profile">
                <img :src="allUserInfo.profile" class="page-img">
            </div>
            <ul class="page-ul">
                <li><a href="#">내 정보</a></li>
            </ul>
        </div>

        <div class="mypage-container">
            <router-view></router-view :userData="allUserInfo">
        </div>
    </div>


</template>

<script setup>
    import { useStore } from 'vuex';
    import { computed, ref, onBeforeMount } from 'vue';
    import LoadingComponent from '../utilities/LoadingComponent.vue'

    const store = useStore();

    const loadingFlg = computed(() => store.state.user.loadingFlg);
    const id = ref(store.state.auth.userInfo.user_id);

    onBeforeMount(() => store.dispatch('user/userDetailPage', id.value));

    const allUserInfo = store.state.auth.userInfo;
</script>

<style scoped>
    .my-page-container {
        display: grid;
        grid-template-columns: 0.3fr 0.8fr;
    }

    .my-page-sidebar {
        display: flex;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        background-color: #F3F3F3;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .profile {
        text-align: center;
        margin-top: 50px
    }

    .page-img {
        background-color: black;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: none;
    }
    .page-ul {
        margin-top: 10px;
    }

    .mypage-container {
        width: 85%;
        margin: 0 auto;
    }
</style>