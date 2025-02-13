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
            <button  @click="goBack" class="button-left">목록</button>
            <button class="button-right">수정</button>            
        </div>
        <router-link to="/community/free"></router-link>        

        <!-- <div class="commnets">
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
            
        </div>         -->

            <!-- 댓글 리스트 -->
            <CommentComponent />
        <div class="freedetail-comment-title">
		<h3>펫브리즈 톡 <span>{{ FreeCommentCnt.cnt }}</span></h3>
	</div>
	<div class="freedetail-comment-form-box">
		<!-- <textarea v-model="comment.free_comment"name="comment" id="comment" placeholder="로그인 후 댓글을 남겨주세요." cols onkeydown="commentresize(this);" minlength="1"></textarea> -->
		<textarea @click="checkToken" v-model="commentData.free_comment" :placeholder="placeholder" name="comment" minlength="1" maxlength="200"></textarea>
		<button @click="storeComment" class="btn-freedetail-comment btn-bg-blue" type="button">등록</button>
	</div>
    </div>
</template>
<script setup>

import { computed, onBeforeMount , reactive ,ref} from 'vue';
import { useRoute ,useRouter} from 'vue-router';
import { useStore } from 'vuex';
// 댓글 컴포넌트
import CommentComponent from '../utilities/CommentComponent.vue';

const store = useStore();

const route = useRoute();

const router = useRouter();

const goBack = () => {
      router.go(-1); // 이전 페이지로 이동
      scrollToTop(); // 최상단으로 스크롤
    };

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    };


const FreeCommentCnt = computed(() => store.state.boards.freeCommentCnt);
// ------------------------------------------
// 댓글 작성
const commentData = reactive({
	comment_content : ''
	,community_id : route.params.id
});

const storeComment = () => {
	if(commentData.comment_content === '') {
		// board.js 에 422 에러문구 처리해서 주석
		// alert('댓글을 작성 해주세요.');
	}
	store.dispatch('boards/storeFreetComment', commentData);
	commentData.comment_content = '';	// 댓글작성후 댓글창에 댓글내용 초기화
};

   
// ------------------------------------------
// 댓글작성시 로그인 확인
// const hasToken = ref(localStorage.getItem('accessToken'));
const checkToken = () => {
	if(!localStorage.getItem('accessToken')) {
		alert('로그인 후 댓글을 작성 해주세요.');
		router.replace('/login');
		// hasToken.value = false;
	}
};

// 댓글 placeholder 로그인, 비로그인시 코멘트
const placeholder = ref('');
const updatePlaceholder = () => {
	if(!localStorage.getItem('accessToken')) {
		placeholder.value='로그인 후 댓글을 남겨주세요.';
	} else {
		placeholder.value='반려동물과 함께한 추억을 작성 해 주세요.';
	}
};
updatePlaceholder();
window.addEventListener('storage', updatePlaceholder);	// storage가 비어질시 실시간 동기화  

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
    .button-wrap {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    .button-left  {
        background-color: #2986FF;
        color: #fff;
        font-size: 1rem;
        width:10%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4px;
        cursor: pointer;
        border: none;
    }
    .button-right {
        background-color: #2986FF;
        color: #fff;
        font-size: 1rem;
        width:10%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4px;
        cursor: pointer;
        border: none;
    }    
    .freedetail-comment-title {
	/* display: inline-block; */
	font-size: 30px;
	margin-bottom: 20px;
    }

    .freedetail-comment-title span {
        color: #2986FF;
    }

    .freedetail-comment-form-box {
        width: 100%;
        padding: 20px;
        display: grid;
        background-color: #CDECFF;
        

    }

    .freedetail-comment-form-box > textarea {
        border: none;
        resize: none;
        width: 100%;
        height: 10em;
        font-size: 15px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .btn-freedetail-comment {
        width: 100px;
        padding: 10px;
        font-size: 20px;
        border: none;
        cursor: pointer;
        justify-self: flex-end;
    }

</style>