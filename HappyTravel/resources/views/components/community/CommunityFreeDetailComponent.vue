<template>
    <div class="cont">
        <div class="free-detail-cont">
            <p class="board-type">자유게시판</p>
            <p class="free-board-title">{{ freeDetail.community_title }}</p>
            <div class="free-detail">
                <span>{{ freeDetail.created_at }}</span>
                <span>{{ freeDetail.users?.nickname }}</span>            
                <span>{{ freeDetail.community_view }}</span>            
                <span>댓글</span>   
            </div>
            <hr>
            <br><br><br>
        </div>
        <div v-html="freeDetail.community_content"></div>
            <br><br><br>
            <hr>
            <br><br><br>
        <div class="button-wrap">
            <button class="button-left">목록</button>
            <button class="buton-right">글쓰기</button>
        </div>
        

        <div class="commnets">
            <h3>댓글: 5</h3>
            <button>댓글 더보기</button>

            <div>
                <span>프로필사진</span>
                <span>닉네임</span>
                <div>댓글내용</div>
                <div>작성날짜</div>
            </div>
            <br>            
            <div>
                <span>프로필사진</span>
                <span>닉네임</span>
                <div>댓글내용</div>
                <div>작성날짜</div>
            </div>
            
            <button>등록</button>
            
        </div>
    </div>
</template>
<script setup>

import { computed, onBeforeMount } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();

const route = useRoute();

onBeforeMount(() => store.dispatch('boards/freeBoardDetail', route.params.id));

const freeDetail = computed(() => store.state.boards.freeDetail);
</script>
<style scoped>
    .cont {
        padding: 0 362px;
    } 
    .board-type {
        margin-bottom: 15px;
    }
    .free-board-title { 
        margin-bottom: 15px;
    }
    .free-detail {
        display: flex;
    }
    .free-detail span { 
        margin-right: 10px;
    }
    .free-detail span:last-child {
        margin-right: 0;
    }
    hr {
        color: #EFEFEF;
    }
</style>