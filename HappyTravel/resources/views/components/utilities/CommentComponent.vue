<template>
    <div v-for="item in PostComment" :key="item" class="comment-box">
        <img class="comment-img" :src="item.user.profile">
        <div class="comment-txt">
            <p>{{ item.post_comment }}</p>
            <button type="button">신고하기</button>
            <div class="comment-created">
                <span class="comment-name">{{ item.user.nickname }}</span>
                <span class="comment-date">{{ item.created_at }}</span>
            </div>
        </div>
    </div>

<button v-if="!isLastPage" @click="loadMoreComments" class="btn btn-bg-blue btn-more" type="button">댓글 더보기</button>
</template>

<script setup>
import { useStore } from 'vuex';
import { computed } from 'vue';
const store = useStore();

// 댓글 리스트 (댓글 정보 가져온다~)
const PostComment = computed(() => store.state.post.postCommentList);

const isLastPage = computed(() => store.state.post.currentPage >= store.state.post.totalPage);
// const loadMoreComments = computed(() => );
</script>

<style scoped>
/* 댓글 창 디자인 */
.comment-box {
	display: grid;
	grid-template-columns: 100px 1fr;
    width: 60%;
	padding: 30px;
	margin: 10px;
	border-bottom: 1px solid #939393;
}

 .comment-img {
	border-radius: 50%;
	width: 70px;
	height: 70px
 }


 .comment-name {
	margin-right: 20px;
	font-weight: 500;
 }

 .comment-date {
	color: #939393;
	font-size: 15px;
 }

 .btn-more {
	width: 100px;
	margin: 20px 0;
 }
</style>