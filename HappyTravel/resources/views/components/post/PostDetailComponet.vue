<template>
<LoadingComponent v-if="isLoading === true"/>
<div class="btn-postdetail-pagenav">
	<router-link to="/index"><span>홈</span></router-link>
	<span> > </span>
	<router-link to="/posts/01"><span>펫브리즈 고</span></router-link>
</div>
	
<div class="postdetail-container">
	<h1 v-if="PostDetail" class="postdetail-title">{{ PostDetail.post_title }}</h1>
	<p v-if="PostDetail" class="postdetail-local">{{ PostDetail.post_local_name }}</p>
	<h3 v-if="PostDetail" class="postdetail-content">{{ PostDetail.post_content }}</h3>
	<div class="postdetail-filter" >
		<span class="filter" v-for="(filter, index) in PostFilter1" :key="index">#{{ filter.animal_type_name }}</span>
		<span class="filter" v-for="(filter, index) in PostFilter2" :key="index">#{{ filter.facility_type_name }}</span>

	</div>
	<ul class="btn-postdetail-nav">
		<li><a href="#" @click.prevent="scrollTo('section1')">사진보기</a></li>
		<li><a href="#" @click.prevent="scrollTo('section2')">상세정보</a></li>
		<li><a href="#" @click.prevent="scrollTo('section3')">여행톡</a></li>
	</ul>

	<div class="postdetail-post-area">
		<div class="postdetail-post-info">
			<div class="postdetail-post-info-area likeArea" >
				<button class="likeBtn" :class="likeBtnClassName" @click="onClkLikeBtn"></button>
				<p>좋아요 : {{ PostDetail.post_likes_count }}</p>
			</div>
			<div class="postdetail-post-info-area viewArea">
				<div class="viewImg"></div>
				<p>조회수 : {{ PostDetail.post_view }}</p>
			</div>
		</div>
	</div>
	<!-- :ref="{swiperRef}" -->
	<button @click="openModal" class="btn btn-bg-grey btn-more">공유하기</button>
	<ShareModalComponent v-show="isModalOpen" @eventClickClose="closeModal" />

		<!-- 이미지 슬라이드 -->
		 <div class="w-full" id="section1">
			 <swiper
				 :pagination="{
					el: '.swiper-pagination',
					type: 'fraction',
						}"
				 :navigation="{
					 nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev' }"
				 :modules="modules"
				 :slidePerView="1"
				 :centeredSlides="true"
				 :touchRatio="1"
				 class="mySwiper"
			 >
				<swiper-slide><img class="postdetail-img" :src="PostDetail.post_subimg1" onerror="src='/developImg/no_img.jpg'"></swiper-slide>
				<swiper-slide><img class="postdetail-img" :src="PostDetail.post_subimg2" onerror="src='/developImg/no_img.jpg'"></swiper-slide>
				<swiper-slide><img class="postdetail-img" :src="PostDetail.post_subimg3" onerror="src='/developImg/no_img.jpg'"></swiper-slide>
				 <div class="swiper-button-next"></div>
				 <div class="swiper-button-prev"></div>
				 <div class="swiper-pagination"></div>
			  </swiper>
		 </div>

	<h3 class="postdetail-title-long-content" id="section2">상세정보</h3>
	<!-- <hr> -->
	<p :class="isExpanded ? 'postdetail-long-content' : 'postdetail-long-content-reduce' ">
		{{ PostDetail.post_detail_content }}
	</p>
	<button @click="toggleContent" class="btn btn-search btn-bg-blue btn-more" type="button">{{ isExpanded ? '내용 접기' : '내용 더보기' }}</button>
	<PostMapComponent />

	<div class="postdetail-info-content">
		<div class="bottom-none">
			<strong>문의 전화: </strong>
			<span>{{ PostDetail.post_detail_num === '0' ? '없음' : PostDetail.post_detail_num }}</span>
		</div>
		<div class="bottom-none">
			<strong>주소: </strong>
			<span>{{ PostDetail.post_detail_addr }}</span>
		</div>
		<div class="bottom-none">
			<strong>홈페이지: </strong>
			<!-- <span><a href="https://www.haeundae.go.kr/tour/" target="_blank">{{ PostDetail.post_detail_site }}</a></span> -->
			<span><a :href="PostDetail.post_detail_site" target="_blank">{{ PostDetail.post_detail_site === null ? '없음' : PostDetail.post_detail_site }}</a></span>
		</div>
		<div class="bottom-none">
			<strong>이용시간: </strong>
			<span>{{ PostDetail.post_detail_time }}</span>
		</div>
		<div class="bottom-none">
			<strong>요금: </strong>
			<span>{{ PostDetail.post_detail_price }}</span>
		</div>
		<div class="bottom-none">
			<strong>차량가능: </strong>
			<!-- 데이터만으로는 0,1로 출력되니 삼향연산자로 출력 -->
			<span>{{ PostDetail.post_detail_parking === '0' ? '주차 불가능' : '주차가능' }}</span>
		</div>
	</div>

	<div class="postdetail-comment-title" id="section3">
		<h3>펫브리즈 톡 <span>{{ PostCommentCnt.cnt }}</span></h3>
	</div>
	<div class="postdetail-comment-form-box">
		<!-- <textarea v-model="comment.post_comment"name="comment" id="comment" placeholder="로그인 후 댓글을 남겨주세요." cols onkeydown="commentresize(this);" minlength="1"></textarea> -->
		<textarea @click="checkToken" v-model="commentData.post_comment" :placeholder="placeholder" name="comment" minlength="1" maxlength="200"></textarea>
		<button @click="storeComment" class="btn-postdetail-comment btn-bg-blue" type="button">등록</button>
	</div>
	<!-- 댓글 리스트 -->
	<CommentComponent />

	
	<!-- 슬라이드 이미지 modal -->
	<!-- <div v-show="modalFlg" class="slide-img-box">
		<div class="swiper-wrapper">
			<swiper
				:style="{
				'--swiper-navigation-color': '#fff',
				'--swiper-pagination-color': '#fff',
				}"
				:loop="true"
				:spaceBetween="10"
				:navigation="{
					nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev' }"
				:thumbs="{ swiper: thumbsSwiper }"
				:modules="modules"
				class="mySwiper2"
			>
			<swiper-slide><img class="postdetail-img thumbs_swiper_img" src="/developImg/post-content-img.png"></swiper-slide>
			<swiper-slide><img class="postdetail-img thumbs_swiper_img" src="/developImg/post-content-img.png"></swiper-slide>
			<swiper-slide><img class="postdetail-img thumbs_swiper_img" src="/developImg/post-content-img.png"></swiper-slide>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
			</swiper>
		</div>
		<swiper
			@swiper="setThumbsSwiper"
			:loop="true"
			:spaceBetween="10"
			:slidesPerView="3"
			:freeMode="true"
			:watchSlidesProgress="true"
			:modules="modules"
			class="mySwiper"
		>
		<div class="item">
			<swiper-slide><img class="postdetail-img thumbs_swiper_img" src="/developImg/post-content-img.png"></swiper-slide>
			<swiper-slide><img class="postdetail-img thumbs_swiper_img" src="/developImg/post-content-img.png"></swiper-slide>
			<swiper-slide><img class="postdetail-img thumbs_swiper_img" src="/developImg/post-content-img.png"></swiper-slide>
		</div>
		</swiper>
			<button @click="closeModal" class="btn btn-bg-blue btn-header next-item4">닫기</button>
		</div> -->
	 </div>
</template>
	
<script setup>
// 지도api 컴포넌트 
import PostMapComponent from './component/PostMapComponent.vue';
// 댓글 컴포넌트
import CommentComponent from '../utilities/CommentComponent.vue';
// 로딩 컴포넌트
import LoadingComponent from '../utilities/LoadingComponent.vue';
// 공유 모달 컴포넌트
import ShareModalComponent from '../utilities/ShareModalComponent.vue';
// 이미지 슬라이드
import { Swiper, SwiperSlide } from 'swiper/vue';

// 이미지 슬라이드
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/free-mode';
import 'swiper/css/thumbs';

// import required modules
import { Pagination, Navigation, Thumbs } from 'swiper/modules';
import { computed, onBeforeMount, onMounted, reactive, ref} from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import router from '../../../js/router';

const modules = reactive([Navigation, Pagination, Thumbs]);
// const thumbsSwiper = ref(null);
// // const thumbs = { swiper: thumbsSwiper.value };
// const setThumbsSwiper = (swiper) => {
// 	thumbsSwiper.value = swiper;
// }
// ------------------------------------------

const store = useStore();
const route = useRoute();

// 포스트 상세 정보    !성공!
const PostDetail = computed(() => store.state.post.postDetail);
const isLoading = computed(() => store.state.post.isDetailLoading);
const PostCommentCnt = computed(() => store.state.post.postCommentCnt);
// -----------------------------------
// 필터
const PostFilter1 = computed(() => store.state.post.postAnimal);
const PostFilter2 = computed(() => store.state.post.postFacility);

// const uniquePostFilters = PostFilter.reduce((acc, current) => {
// 	if(!acc.some(PostFilter => PostFilter.animal_type_name === current.animal_type_name)) {
// 		acc.push(current);
// 	} return acc;
// }, []);

//  ------------------------------------------
// 라우트 변경 시 데이터 다시 호출 
onBeforeMount(()=>{
	store.dispatch('post/showPost', route.params.id);
	// store.commit('post/setInitialize');
});
// ------------------------------------------
// 모달 관련
// 모달숨기기
const modalFlg = ref(false);
// 모달 열기
// const openModal = () => {
// 	modalFlg.value = true;
// }; 
// 모달 닫기
// const closeModal = () => {
// 	modalFlg.value = false;
// };
// ------------------------------------------
// 상단 사진,내용,여행톡 이동
const scrollTo = (id) => {
	const element = document.getElementById(id);
	if(element) {
		element.scrollIntoView({ behavior: 'smooth' });
	}
};

// 좋아요 버튼 관련
const isClked = computed(() => store.state.post.isClkedLike);
const likeBtnClassName = computed(() => (isClked.value ? 'clk' : 'noClk'));

onMounted(()=>{
	likeBtnClassName.value = isClked.value ? 'clk' : 'noClk';
})

const onClkLikeBtn = () => {
	if(!store.state.auth.authFlg){
		alert('로그인 후 이용할 수 있습니다.');
		router.push('/login');
		return;
	}

	store.dispatch('post/postClickLike', route.params.id);

	likeBtnClassName.value = isClked.value ? 'clk' : 'noClk';
}

// ------------------------------------------
// 포스트 상세 내용 모두 출력 => 기존에 false로 줄임상태에서 버튼 클릭 이벤트시 true로 전환하고 css 바꾸기
const isExpanded = ref(false);
const toggleContent = () => {
	isExpanded.value = !isExpanded.value;
};

// ------------------------------------------
// 댓글 작성
const commentData = reactive({
	post_comment : ''
	,post_id : route.params.id
});

const storeComment = () => {
	if(commentData.post_comment === '') {
		// post.js 에 422 에러문구 처리해서 주석
		// alert('댓글을 작성 해주세요.');
	}
	store.dispatch('post/storePostComment', commentData);
	commentData.post_comment = '';	// 댓글작성후 댓글창에 댓글내용 초기화
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
// ------------------------------------------
// 공유하기
// window.onload = function() {
// 	const btnShareX = document.querySelector('#shareX');
// 	btnShareX.addEventListener('click', () => {
// 		const pageUrl = 'http://127.0.0.1:8000/posts/30';
// 		const text = '야호테스트';
// 		window.open("https://twitter.com/intent/tweet?text=" + text + "&url=" + pageUrl);
// 	})
// };

const isModalOpen = ref(false);
// 모달 열기
const openModal = () => {
	isModalOpen.value = true;
};

const closeModal = () => {
	isModalOpen.value = false;
};

</script>
	
<style scoped>
/* li 하단 파란줄 부분 없앰 */
.bottom-none:hover::before {
	width: 0;
}

/* 제일 윗상단 이동 */
.btn-postdetail-pagenav {
	padding: 20px;
	margin-left: 50px;
}

.postdetail-container {
	width: 100%;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.postdetail-filter {
	display: flex;
	flex-direction: row;
	gap: 10px;
	margin-bottom: 10px;
	max-width: 70%;
}

.filter {
	background-color: #398fff;
	color: #fff;
	padding: 10px;
	border-radius: 20px;
}

/* 좋아요, 조회수 영역 */
.postdetail-post-area {
	display: flex;
	justify-content: center;

	width: 50%;
	/* margin-left: 300px; */
}

.postdetail-post-info{
	display: flex;
	gap: 2rem;
}

.postdetail-post-info-area{
	display: flex;
	flex-direction: column;

	justify-content: center;
	align-items: center;

	gap: 0.5rem;
}

.likeBtn{
	width: 5rem;
	height: 5rem;

	border: 1px solid rgb(0, 0, 0);
	border-radius: 100%;

	cursor: pointer;

	background-position: center;
	background-repeat: no-repeat;
	background-size: 50%;

	background-color: white;
}

.noClk{
	/* background-color: magenta; */
	background-image: url('/developImg/like_no.png');
}

.clk{
	/* background-color: #2986FF; */
	background-image: url('/developImg/like_yes.png');
	color: red;
}

.viewImg{
	width: 5rem;
	height: 5rem;

	border: 1px solid rgb(0, 0, 0);
	border-radius: 100%;

	background-image: url('/developImg/views.png');
	background-size: 50%;
	background-repeat: no-repeat;
	background-position: center;
}

.postdetail-title {
	font-size: 50px;
}

.postdetail-local {
	color: #939393;
	font-weight: 500;
	margin-bottom: 10px;
}

.postdetail-content {
	font-size: 23px;
	padding: 0 15px;
	font-weight: 700;
	box-shadow: inset 0 -12px 0 rgb(205, 236, 255);
	margin-bottom: 20px;
}

.btn-postdetail-nav {
	padding: 20px;
	border-top: 3px  solid#D9D9D9;
	border-bottom: 3px  solid#D9D9D9;
	margin-bottom: 20px;
}

.w-full {
	width: 60%;
	height: 50%;
}

:root {
  --swiper-theme-color: #fff;
}

.swiper-button-next , .swiper-button-prev {
	color: #fff;
}

.swiper-pagination {
	display: inline-block;
	text-align: center;
	width: 100px;
	color: #fff;
	background-color: rgba(0, 0, 0, 0.7);
	border-radius: 20px;
	margin-bottom: 50px;
	padding: 5px;
	margin-left: 950px;
}

.postdetail-img {
	width: 100%;
	aspect-ratio: 16/9;
	margin-bottom: 20px;
}

.postdetail-title-long-content {
	font-size: 30px;
	margin-bottom: 10px;
	padding-bottom: 10px;
	width: 70%;
	border-bottom: 2px solid #d3d3d3;
}

.postdetail-long-content {
	margin-top: 10px;
	font-size: 20px;
	width: 60%;
}

.postdetail-long-content-reduce {
	margin-top: 10px;
	font-size: 20px;
	display: -webkit-box;
	-webkit-line-clamp: 4;
	overflow: hidden;
	text-overflow: ellipsis;
	-webkit-box-orient: vertical;
	width: 60%;
}

.postdetail-info-content {
	margin-bottom: 20px;
}

.postdetail-comment-title {
	/* display: inline-block; */
	font-size: 30px;
	margin-bottom: 20px;
}

.postdetail-comment-title span {
	color: #2986FF;
}

.postdetail-comment-form-box {
	width: 60%;
	padding: 20px;
	display: grid;
	background-color: #CDECFF;
	

}

.postdetail-comment-form-box > textarea {
	border: none;
	resize: none;
    width: 100%;
	height: 10em;
	font-size: 15px;
    padding: 10px;
	margin-bottom: 10px;
}

.btn-postdetail-comment {
	width: 100px;
	padding: 10px;
	font-size: 20px;
	border: none;
	cursor: pointer;
	justify-self: flex-end;
}


.comment-txt {
	width: 100%;
}

.postdetail-post-area {
	margin-bottom: 10px;
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(1fr 1fr));
	
}

 .btn-more {
	width: 100px;
	margin: 20px 0;
 }

 .slide-img-box {
	position: fixed;
    display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    width: 100vw;
    height: 100vh;
	z-index: 100;
 }

.swiper-wrapper {
	text-align: center;
}

.item {
	display: grid;
	grid-template-rows: 200px 200px 200px;
}

.thumbs_swiper_img {
	margin-top: 100px;
	width: 1200px;
	height: 700px;
}


</style>