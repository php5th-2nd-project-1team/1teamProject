<template>
    <div class="community-photos-card-container">
        <div class="community-photos-card" v-for="(item, key) in $store.state.boards.showoffList" :key="key">
            <img class="community-photos-img" :src="item?.community_photos?.length > 0 ? item?.community_photos[0]?.community_photo_url : ''" alt="">
            <h3 class="community-photos-card-title">{{ item?.community_title }}</h3>
            <div class="community-photos-user-info">
                <p><img class="community-photos-user-profile" :src="item?.users?.profile" alt=""></p>
                <p>{{ item?.users?.nickname }}</p>
            </div>
            <div class="community-photos-card-info">
                <img  class="community-views-img"src="/developImg/views.png" alt=""><p>{{ item?.community_view }}</p>
                <p>{{ item?.created_at }}</p>
            </div>
        </div>
    </div>
    <div class="commuinity-photos-btn">
        <button class="btn btn-header btn-bg-gray btn-community-photos-more" type="button" @click="nextPage">더 알아보기</button>        
    </div>

</template>
<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const page = ref(1);

onBeforeMount(() => {
    store.dispatch('boards/CommunityShowoffPagination', page.value);
    page.value++;
});

function nextPage() {
    store.dispatch('boards/CommunityShowoffPagination', page.value);
    page.value++;
}
</script>

<style scoped>
.community-photos-card-container {
    text-align: left;
    margin: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 20px;
}

.community-photo-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap : 0.1rem;
    cursor: pointer;
    
}
.community-photos-card-title {
    text-align: left;
    margin: 20px;
}
.community-photos-img {
    width: 100%;
    height: 300px;
    border-radius: 30px;
    opacity: 1;
    transition: .2s ease-in-out;
}
.community-photos-img:hover {
    opacity: .8;
}

.community-photos-user-info {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    gap: 20px;
    margin: 20px;
}

.community-photos-user-profile {
    width: 100%;
    height: 40px;
}
.community-photos-card-info {
    width: 80%;
    display: flex;
    flex-direction: row;
    justify-content: left;
    align-items: center;
    gap : 10px;
    margin: 20px;
}
.community-views-img {
    height: 30px;
}

/* 포스트 내용 더 알아보기 가운데 정렬 */
.commuinity-photos-btn {
    text-align: center;
}

/* 포스트 내용 더 알아보기 버튼 */
.btn-community-photos-more {
    width: 200px;
    margin-top: 50px;
    
}  
</style>