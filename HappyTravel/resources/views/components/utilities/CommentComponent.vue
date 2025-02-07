<template>
    <div v-for="(item, key) in PostComment" :key="item" class="comment-box">
        <img class="comment-img" :src="item.user.profile">
        <!-- <img class="comment-img" src="/profile/GJfqlZza8AAd1_K.jfif"> -->
        <div class="comment-txt">
            <p>{{ item.post_comment }}</p>
			<div class="etc-btn">
				<!-- 신고버튼 -->
				<!-- 신고버튼 클릭시 comment_id를 파라미터로 보내줄거임 -->
				<button @click="openReportModal(item.post_comment_id)" v-if="item.user.user_id !== $store.state.auth.userInfo.user_id" class="btn-comment-report" type="button"><img src="/developImg/btn_reply_report.png" alt=""></button>
				<!-- 삭제버튼 -->
				<button v-if="item.user.user_id === $store.state.auth.userInfo.user_id" @click="deleteComment(item.post_comment_id, key)" class="btn-comment-delete"><img style="width: 25px;" src="/developImg/btn-delete.png" alt=""></button>
			</div>
            <div class="comment-created">
                <span class="comment-name">{{ item.user.nickname }}</span>
                <span class="comment-date">{{ item.created_at }}</span>
            </div>
        </div>
    </div>

<button v-if="!isLastPage" @click="loadMoreComments" class="btn btn-bg-blue btn-more" type="button">댓글 더보기</button>
<ReportComponent :commentId = "commentId" v-show="isOpenReportModal"  @postReportClose=closeReportModal />
</template>

<script setup>
import { useStore } from 'vuex';
import { computed, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import ReportComponent from './ReportComponent.vue';
const store = useStore();
const route = useRoute();

const commentId = ref(0);

// 댓글 리스트 (댓글 정보 가져온다~)
const PostComment = computed(() => store.state.post.postCommentList);

const isLastPage = computed(() => store.state.post.lastPageFlg);
// ------------------------------------------
// 댓글 페이지네이션
const loadMoreComments = () => {
	store.dispatch('post/postCommentPagination', route.params.id);
	console.log(route.params);
};

// ------------------------------------------
// 댓글 삭제
const deleteComment = (id, key) => {
	store.dispatch('post/postCommentDelete', [id, key]);
};
// ------------------------------------------
// 신고 모달
const isOpenReportModal = ref(false);
const openReportModal = (comment_id) => {
	commentId.value = comment_id;
    isOpenReportModal.value = true;
}

const closeReportModal = () => {
    isOpenReportModal.value = false;
}

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
	margin: 20px 0;
 }

 .btn-comment-delete {
	text-align: center;
	cursor: pointer;
	border: none;
	background-color: transparent;
	margin: 0 5px;
	width: 30px;
 }

 .btn-comment-report {
	border: 0;
	outline: 0;
	background-color: transparent;
	cursor: pointer;
 }
</style>