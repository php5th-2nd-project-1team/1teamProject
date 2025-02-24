<template>
    <h1>자랑게시판</h1> 

    <div class="showoff-content-contaier">
            <p class="showoff-content-title">{{ $store.state.boards.showoffDetail?.community_title }}</p>
        <div class="showoff-content-info">
            <span>
                <img class="user-profile" :src="$store.state.boards.showoffDetail?.users?.profile" alt="">
            </span>
            <span class="user-nickname">{{ $store.state.boards.showoffDetail?.users?.nickname }}</span>
        </div>

        <div class="showoff-content-slide-container">
            <img v-if="$store.state.boards.showoffDetail?.community_photos" :src="$store.state.boards.showoffDetail?.community_photos[0]?.community_photo_url" alt="">
        </div>

        <div class="showoff-content-footer">
            <div class="showoff-content-text">
                <div v-html="showoffDetail?.community_content"></div>
                <!-- <p class="showoff-contet">{{ $store.state.boards.showoffDetail?.community_content }}</p> -->
            </div>
        </div>
    </div>  
    <br><br><br><br><br>
    <hr>
    <br><br><br><br><br>
    <div class="button-wrap">
        <button @click="goBack" class="button-left">목록</button>
    </div>
    <div class="showoff-comment-container">
		<!-- 댓글 리스트 -->
		<div class="showoff-comment-title">
			<h3>펫브리즈 톡 <span>{{  $store.state.boards.freeCommentCnt }}</span></h3>
		</div>

		<!-- 댓글 작성 부분 -->
		<div class="showoff-comment-form-box">
			<textarea 
				@click="checkToken"
				v-model="commentData.comment_content"
				:placeholder="placeholder"
				name="comment"
				minlength="1"
				maxlength="200"
			></textarea>
			<button 
				@click="storeComment"
				class="btn-showoff-comment btn-bg-blue"
				type="button"
			>등록</button>
		</div>
    </div>
    <CommunityCommnet />
    
</template>
<script setup>
import { computed, onBeforeMount, onMounted, reactive, ref } from 'vue';
import CommunityCommnet from './CommunityCommnet.vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';

const store = useStore();
const route = useRoute();
const router = useRouter();

const showoffDetail = computed(() => store.state.boards.showoffDetail);

onBeforeMount(() => {
    store.dispatch('boards/showCommunityShowoff', route.params.id);
});

const goBack = () => {
		router.go(-1); // 이전 페이지로 이동
		scrollToTop(); // 최상단으로 스크롤
	};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
    
// 댓글 작성
// 댓글 데이터
const commentData = reactive({
    comment_content: '',
    community_id: route.params.id
});

// 댓글 저장
const storeComment = async() => {		
    if (commentData.comment_content.trim() === '') {
        alert('댓글을 작성 해 주세요.');
        return;
    }
    await store.dispatch('boards/storeFreeComment', commentData);
    commentData.comment_content = '';
};

// 댓글작성시 로그인 확인
const checkToken = () => {
    if (!localStorage.getItem('accessToken')) {
        alert('로그인 후 댓글을 작성 해주세요.');
        router.replace('/login');
    }
};

// 댓글 placeholder 로그인, 비로그인시 코멘트
const placeholder = ref('');
const updatePlaceholder = () => {
    if (!localStorage.getItem('accessToken')) {
        placeholder.value = '로그인 후 댓글을 남겨주세요.';
    } else {
        placeholder.value = '반려동물과 함께한 추억을 작성 해 주세요.';
    }
};
onMounted(() => {
    updatePlaceholder();
    window.addEventListener('storage', updatePlaceholder);
})

</script>
<style scoped>
    h1 { 
        text-align: center;
        margin-top: 20px;
    }
    hr {
        width: 60%;
        margin: 0 362px;
    }
    /* 자랑게시판 전체 컨테이너 */
    .showoff-content-contaier  {
        width: 80%;
        margin: 0 362px;
        margin-top: 50px;
    }
    /* 자랑게시판 컨텐츠 제목 */
    .showoff-content-title {
        margin-bottom: 20px;
        font-size: 2rem;
    }
    /* 자랑게시판 컨텐츠 정보 */
    .showoff-content-info {
        display: flex;
        align-items: center; /* 세로 중앙 정렬 */
        gap: 15px; /* 이미지와 닉네임 간격 추가 */
    }   
    /* 자랑게시판 유저 프로필 */
    .user-profile {
        width: 40px; /* 이미지 크기 조절 */
        height: 40px;
        border-radius: 50%; /* 동그랗게 */
    }
    /* 자랑게시판 유저 닉네임 */
    .user-nickname {
        font-size: 1.1rem;
        font-weight: bold;
        display: flex;
        align-items: center; /* 세로 중앙 정렬 */
    }

    .button-wrap {
		display: flex;
		justify-content: flex-start;
        width: 80%;
		margin: 0 362px;
        margin-bottom: 50px;

	}
	.btn-actions {
		display: flex;
		justify-content: flex-end;
		align-items: center;
		width:68%;
		gap: 10px;
	}
	
	.button-left {
		background-color: #2986FF;
		color: #fff;
		font-size: 1rem;
		width: 10%;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 4px;
		cursor: pointer;
		border: none;
	}
	

    /* 자랑게시판 컨텐츠 슬라이드 컨테이너
    .showoff-content-slide-container {
        width:100%;
        height: 100%;     
        text-align: center;
    } 
    .btn-radius-wrap  {
        display: flex;
        margin: 20px;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }
    .btn-radius-wrap >button {
        border-radius: 50%;
        width: 20px; /* 버튼 크기 */
        /* height: 20px;
        border:none;        
        cursor: pointer;
    } */ 

    
    
    /* 자랑게시판 컨텐츠 footer */ 
    .showoff-content-footer {      
        margin: 0 auto;
    }
    .showoff-likes-btn {
        border: none;
        cursor: pointer;
        background: none; /* 배경 없애기 */
    }
    .showoff-likes {
        
        width: 40px;
        height: 40px;
    }

    /* 좋아요 개수와 게시글 내용을 감싸는 영역 */
    
	.showoff-comment-title {
		font-size: 30px;
		margin-bottom: 20px;
	}
	
	.showoff-comment-title span {
		color: #2986FF;
	}
	
	.showoff-comment-form-box {
		width: 100%;
		padding: 20px;
		display: grid;
		background-color: #CDECFF;
	}
	
	.showoff-comment-form-box > textarea {
		border: none;
		resize: none;
		width: 100%;
		height: 10em;
		font-size: 15px;
		padding: 10px;
		margin-bottom: 10px;
	}
	
	.btn-showoff-comment {
		width: 100px;
		padding: 10px;
		font-size: 20px;
		border: none;
		cursor: pointer;
		justify-self: flex-end;
	}

    .showoff-comment-container {
		padding: 0 362px;
    }
    /* .showoff-comment-title {
		font-size: 30px;
		margin-bottom: 20px;
	}
	
	.showoff-comment-title span {
		color: #2986FF;
	}
	
	.showoff-comment-form-box {
		width: 100%;
		padding: 20px;
		display: grid;
		background-color: #CDECFF;
	}
	
	.showoff-comment-form-box > textarea {
		border: none;
		resize: none;
		width: 100%;
		height: 10em;
		font-size: 15px;
		padding: 10px;
		margin-bottom: 10px;
	}
	
	.btn-showoff-comment {
		width: 100px;
		padding: 10px;
		font-size: 20px;
		border: none;
		cursor: pointer;
		justify-self: flex-end;
	} */
</style>