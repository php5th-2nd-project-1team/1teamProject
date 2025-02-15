<template>
    <div class="comment-container">
        <div v-for="(item, key) in comments" :key="item" class="comment-box">
            <img class="comment-img" :src="item.users.profile">
            <!-- <img class="comment-img" src="/profile/GJfqlZza8AAd1_K.jfif"> -->
            <div class="comment-txt">
                <p>{{ item.comment_content }}</p>
                <div class="etc-btn">
                    <!-- 삭제버튼 -->
                    <button v-if="item.users.user_id === $store.state.auth.userInfo.user_id" @click="deleteComment(item.community_comment_id, key)" class="btn-comment-delete">
                        <img style="width: 25px;" src="/developImg/btn-delete.png" alt="">
                    </button>
                </div>
                <div class="comment-created">
                    <span class="comment-name">{{ item.users.nickname }}</span>
                    <span class="comment-date">{{ item.created_at }}</span>
                </div>
            </div>
        </div>

        <!-- <button v-if="!isLastPage" @click="loadMoreComments" class="btn btn-bg-blue btn-more" type="button">댓글 더보기</button> -->
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import { computed, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

// 댓글 리스트 (댓글 정보 가져온다~)
const comments = computed(() => store.state.boards.freeCommentList);
const isLastPage = computed(() => store.state.boards.lastPageFlg);

// ------------------------------------------
// 댓글 페이지네이션
const loadMoreComments = () => {
	store.dispatch('boards/freeCommentPagination', route.params.id);
};

// ------------------------------------------
// 댓글 삭제
const deleteComment = (id, key) => {
	store.dispatch('boards/freeCommentDelete', [id, key]);
};
</script>

<style scoped>
.comment-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;

}

/* 댓글 창 디자인 */
.comment-box {
	display: grid;
	grid-template-columns: 100px 1fr;
	width: 60%;
	padding: 30px;
	margin: auto;
	border-bottom: 1px solid #939393;
}

.etc-btn {
	display: flex;
	justify-content: flex-end;
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
	margin: 20px auto;
}

.btn-comment-delete {
	text-align: center;
	cursor: pointer;
	border: none;
	background-color: transparent;
	/* margin: 0 5px; */
	width: 30px;
}

.btn-comment-report {
	border: 0;
	outline: 0;
	background-color: transparent;
	cursor: pointer;
	margin: 0 5px;
}
</style>