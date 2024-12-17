<template>

<div class="btn-postdetail-pagenav">
	<a href=""><span>홈</span></a>
	<span> > </span>
	<a href=""><span>펫브리즈 고</span></a>
</div>
	
<div class="postdetail-container">
	<h1 v-if="PostDetail" class="postdetail-title">{{ PostDetail.post_title }}</h1>
	<p v-if="PostDetail" class="postdetail-local">{{ PostDetail.post_local_name }}</p>
	<h3 v-if="PostDetail" class="postdetail-content">{{ PostDetail.post_content }}</h3>
	<ul class="btn-postdetail-nav">
		<li><a href="">사진보기</a></li>
		<li><a href="">상세정보</a></li>
		<li><a href="">여행톡</a></li>
	</ul>

	<div class="postdetail-post-area">
		<button type="button">
			<span>좋아요</span>
			<span>{{ PostDetail.post_like }}</span>
		</button>
		<span>
			<span>조회수</span>
			<span>{{ PostDetail.post_view }}</span>
		</span>
	</div>

		<!-- 이미지 슬라이드 -->
		 <div class="w-full">
			 <swiper
			 	:ref="{swiperRef}"
				 :pagination="{
					el: '.swiper-pagination',
					type: 'fraction',
						}"
				 :navigation="{
					 nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev' }"
				 :modules="modules"
				 :slidePerView="1"
				 :centeredSlides="true"
				 :touchRatio="0"
				 class="mySwiper"
			 >
				<swiper-slide @click="openModal"><img class="postdetail-img" :src="PostDetail.post_subimg1"></swiper-slide>
				<swiper-slide @click="openModal"><img class="postdetail-img" :src="PostDetail.post_subimg2"></swiper-slide>
				<swiper-slide @click="openModal"><img class="postdetail-img" :src="PostDetail.post_subimg3"></swiper-slide>
				 <div class="swiper-button-next"></div>
				 <div class="swiper-button-prev"></div>
				 <div class="swiper-pagination"></div>
			  </swiper>
		 </div>

	<h3 class="postdetail-title-long-content">상세정보</h3>
	<!-- <hr> -->
	<p :class="isExpanded ? 'postdetail-long-content' : 'postdetail-long-content-reduce' ">
		{{ PostDetail.post_detail_content }}
	</p>
	<button @click="toggleContent" class="btn btn-search btn-bg-blue btn-more" type="button">{{ isExpanded ? '내용 접기' : '내용 더보기' }}</button>
	<PostMapComponent />

	<div class="postdetail-info-content">
		<div class="bottom-none">
			<strong>문의 전화: </strong>
			<span>{{ PostDetail.post_detail_num === null ? '없음' : PostDetail.post_detail_num }}</span>
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

	<div class="postdetail-comment-title">
		<h3>펫브리즈 톡 <span>50</span></h3>
	</div>
	<div class="postdetail-comment-form-box">
		<!-- <textarea v-model="comment.post_comment"name="comment" id="comment" placeholder="로그인 후 댓글을 남겨주세요." cols onkeydown="commentresize(this);" minlength="1"></textarea> -->
		<textarea v-model="comment.post_comment"name="comment" id="comment" placeholder="로그인 후 댓글을 남겨주세요." minlength="1"></textarea>
		<button @click="$store.dispatch('post/storePostComment', post_comment)" class="btn-postdetail-comment btn-bg-blue" type="button">등록</button>
	</div>
	<ul>
		<li class="bottom-none">
			<div class="comment-box">
				<img class="comment-img" src="/developImg/seoul_icon.png" alt="">
				<div class="comment-txt">
					<p>펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!</p>
					<button type="button">신고하기</button>
					<div class="comment-created">
						<span class="comment-name">펫타곤</span>
						<!-- <span>펫타곤{{ $store.state.post.comment.name }}</span> -->
						<span class="comment-date">2024-12-10</span>
					</div>
				</div>
			</div>
		</li>

		<li class="bottom-none">
			<div class="comment-box">
				<img class="comment-img" src="/developImg/seoul_icon.png" alt="">
				<div class="comment-txt">
					<p>펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!!!!</p>
					<button type="button">신고하기</button>
					<div class="comment-created">
						<span class="comment-name">펫타곤</span>
						<!-- <span>펫타곤{{ $store.state.post.comment.name }}</span> -->
						<span class="comment-date">2024-12-10</span>
					</div>
				</div>
			</div>
		</li>
	</ul>

	<!-- <div class="postdetail-comment-list"> -->
	<!-- </div> -->
	
	<button class="btn btn-bg-blue btn-more" type="button">댓글 더보기</button>

	<!-- 슬라이드 이미지 modal -->
	<div v-show="modalFlg" class="slide-img-box">
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
		</div>
	 </div>
</template>
	
<script setup>
// 지도api 컴포넌트 
import PostMapComponent from './component/PostMapComponent.vue';
// 이미지 슬라이드
import { Swiper, SwiperSlide } from 'swiper/vue';

// 이미지 슬라이드
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/free-mode';
import 'swiper/css/thumbs';

// import required modules
import { Pagination, Navigation, Thumbs, FreeMode } from 'swiper/modules';
import { computed, onBeforeMount, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const modules = reactive([Navigation, Pagination, Thumbs]);
const thumbsSwiper = ref(null);
// const thumbs = { swiper: thumbsSwiper.value };
const setThumbsSwiper = (swiper) => {
	thumbsSwiper.value = swiper;
}
// ------------------------------------------

const store = useStore();

// 포스트 상세 정보    !성공!
const PostDetail = computed(() => store.state.post.postDetail);

//  ------------------------------------------
// 데이터 호출 
const route = useRoute();
onBeforeMount(()=>{
	store.dispatch('post/showPost', route.params.id);
});


// ------------------------------------------
// 모달 관련
// 모달숨기기
const modalFlg = ref(false);
// 모달 열기
const openModal = () => {
	modalFlg.value = true;
}; 
// 모달 닫기
const closeModal = () => {
	modalFlg.value = false;
};
// ------------------------------------------
// 로딩 관련

// ------------------------------------------
// 포스트 상세 내용 모두 출력 => 기존에 false로 줄임상태에서 버튼 클릭 이벤트시 true로 전환하고 css 바꾸기
const isExpanded = ref(false);
const toggleContent = () => {
	isExpanded.value = !isExpanded.value;
};

// ------------------------------------------
// 댓글 작성
const comment = reactive({
	post_comment: ''
});

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

.postdetail-post-area {
	margin-left: 300px;
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

/* .postdetail-img-container {
	display: flex;
} */

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
	height: 100%;
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
	-webkit-line-clamp: 7;
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
	/* display: grid;
	grid-template-columns: repeat(auto-fill, minmax( 1fr)); */
	background-color: #CDECFF;
	

}

.postdetail-comment-form-box > textarea {
	border: none;
	resize: none;
    width: 100%;
	height: 10em;
    padding: 10px;
	margin-bottom: 10px;
}

.btn-postdetail-comment {
	width: 100px;
	padding: 10px;
	font-size: 15px;
	border: none;
	cursor: pointer;
}


.comment-txt {
	width: 100%;
}

.postdetail-post-area {
	margin-bottom: 10px;
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(1fr 1fr));
	
}


 /* 댓글 창 디자인 */
.comment-box {
	display: grid;
	grid-template-columns: 100px 1fr;
	padding: 30px;
	margin: 30px 50px;
	border-bottom: 1px solid #939393;
}

 .comment-img {
	border-radius: 50%;
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