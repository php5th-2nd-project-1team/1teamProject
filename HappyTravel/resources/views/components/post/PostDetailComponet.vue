<template>
	<div class="postdetail-container">
		<!-- 상단 페이지 이동 -->
		<div class="btn-postdetail-pagenav">
			<a href="#">홈</a>
			<span> > </span>
			<a href="#">펫브리즈 고</a>
		</div>
		<!-- 포스트 상단 -->
		<div class="postdetail-header">
			<h1>조양방직</h1>
			<p>인천 강화군</p>
			<h3>강화도 방직공장을 개조한 레트로 감성카페</h3>
			<div class="postdetail-navbar">
				<ul>
					<li class="btn-postdetail-nav">
						<a href="#postdetail-img">사진보기</a>
					</li>
					<li class="btn-postdetail-nav">
						<a href="#postdetail-main">상세정보</a>
					</li>
					<li class="btn-postdetail-nav">
						<a href="#postdetail-comment">여행톡</a>
					</li>
				</ul>
			</div>
			<!-- TODO: 좋아요, 조회수 : 형태만 넣어두고 나중에 기능 추가 -->
			<div class="postdetail-post-area">
				<button type="button">
					<span>좋아요</span>
					<span>50</span>
				</button>
				<span>
					<span>조회수</span>
					<span>10000</span>
				</span>
			</div>
			<!-- 포스트 메인 -->
			<img id="postdetail-img" class="postdetail-img" src="/developImg/post-content-img.png" alt="">
			<div id="postdetail-main" class="postdetail-main">
				<h3>상세정보</h3>
				<hr>
				<p>
					1933년 국내 자본으로 설립된 강화 최초의 인견 공장이었던 조양 방직은 세월이 흘러 강화 직물이 쇠락하자 폐가로 전락했다. 흉물스럽게 쓰러져가던 건물은 거대한 카페로 재탄생하였다. 허물어져 가던 벽면은 근사한 미술관이며 영화관이 됐고, 기다란 작업대는 커피 테이블로 바뀌었으며, 기계도 사람도 떠난 공간은 중국과 유럽 등지에서 찾은 골동품으로 채워졌다. 깨진 유리창을 간직한 영국제 문짝, 체코의 옛 기차에 달렸던 둥근 거울, 겨울마다 몸을 뒤집느라 애쓴 붕어빵 기계가 원래부터 그 자리에 있었던 듯 자연스럽게 배치하여 990㎡(약 300평)가 넘는 공장 터와 건물 골조를 그대로 살려 시간의 이야기를 카페 곳곳에 남겨두고 있다. 현재 각종 음료와 케이크를 판매하고 있다.
					현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.
					1933년 국내 자본으로 설립된 강화 최초의 인견 공장이었던 조양 방직은 세월이 흘러 강화 직물이 쇠락하자 폐가로 전락했다. 흉물스럽게 쓰러져가던 건물은 거대한 카페로 재탄생하였다. 허물어져 가던 벽면은 근사한 미술관이며 영화관이 됐고, 기다란 작업대는 커피 테이블로 바뀌었으며, 기계도 사람도 떠난 공간은 중국과 유럽 등지에서 찾은 골동품으로 채워졌다. 깨진 유리창을 간직한 영국제 문짝, 체코의 옛 기차에 달렸던 둥근 거울, 겨울마다 몸을 뒤집느라 애쓴 붕어빵 기계가 원래부터 그 자리에 있었던 듯 자연스럽게 배치하여 990㎡(약 300평)가 넘는 공장 터와 건물 골조를 그대로 살려 시간의 이야기를 카페 곳곳에 남겨두고 있다. 현재 각종 음료와 케이크를 판매하고 있다.
					현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.현재 각종 음료와 케이크를 판매하고 있다.
				</p>
			</div>
			<button class="btn btn-search btn-bg-blue btn-more" type="button">내용 더보기</button>
			<!-- 포스트 지도, 세부정보 -->
			<div class="postdetail-info-container">
				<img class="postdetail-info-map" src="/developImg/map_img_test.png" alt="">
				<div class="postdetail-info">
					<div class="postdetail-info-content">
						<div class="bottom-none">
							<strong>문의 전화: </strong>
							<span>051-749-7621</span>
						</div>
						<div class="bottom-none">
							<strong>주소: </strong>
							<span>부산광역시 해운대구 동백로 67 (우동) 일대</span>
						</div>
						<div class="bottom-none">
							<strong>홈페이지: </strong>
							<span><a href="https://www.haeundae.go.kr/tour/" target="_blank">https://www.haeundae.go.kr/tour/</a></span>
						</div>
						<div class="bottom-none">
							<strong>이용시간: </strong>
							<span>상시개방</span>
						</div>
						<div class="bottom-none">
							<strong>차량: </strong>
							<span>가능</span>
						</div>
					</div>
			</div>
		</div>
	</div>
	<!-- 댓글기능 -->
		<div id="postdetail-comment" class="postdetail-comment-container">
			<div class="postdetail-comment-title">
				<h3>펫브리즈 톡 <span>50</span></h3>
			</div>
			<div class="postdetail-comment-form-container">
				<div class="postdetail-comment-form-box">
					<!-- <input type="text" placeholder="에티켓을 지켜주세요."> -->
					<textarea name="comment" id="comment" placeholder="로그인 후 댓글을 남겨주세요." cols onkeydown="commentresize(this);" minlength="1"></textarea>
					<div class="postdetail-comment-btn-wrap">
						<button class="btn-postdetail-comment btn-bg-blue" type="button">등록</button>
					</div>
				</div>
			</div>
			<!-- 댓글 파트 -->
			 <div class="postdetail-comment-list">
				<ul>
					<li class="bottom-none">
						<div class="comment-box">
							<img class="comment-img" src="/developImg/seoul_icon.png" alt="">
							<div class="comment-txt">
								<p>펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!! 펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!! 펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!</p>
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
								<p>펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!! 펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!! 펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!펫브리즈에서 강아지와 즐거운 시간을 보냈어요!!!</p>
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
				<div class="bottom-btn">
					<button class="btn btn-search btn-bg-blue btn-more" type="button">댓글 더보기</button>
				</div>
			 </div>
		</div>
	</div>
</template>

<script setup>
</script>

<style scoped>
.bottom-none:hover::before {
	width: 0;
}

.btn-postdetail-pagenav {
	padding: 20px;
	margin-left: 50px;
}

.postdetail-header {
	text-align: center;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.postdetail-header > h1 {
	font-size: 50px;
}

.postdetail-header > p {
	color: #939393;
	font-weight: 500;
	margin-bottom: 10px;
}

.postdetail-header > h3 {
	font-size: 23px;
	padding: 0 15px;
	font-weight: 700;
	box-shadow: inset 0 -12px 0 rgb(205, 236, 255);
	margin-bottom: 20px;
}

.postdetail-navbar {
	padding: 20px;
	border-top: 3px  solid#D9D9D9;
	border-bottom: 3px  solid#D9D9D9;
	margin-bottom: 20px;
}

.btn-postdetail-nav {
	padding: 0 10px;
}

.postdetail-img {
	width: 950px;
}

.postdetail-main {
	/* padding: 30px; */
	margin: 50px 300px 20px 300px;
	text-align: left;
	
}

.postdetail-main > h3 {
	font-size: 30px;
	margin-bottom: 10px;
}

.postdetail-main > p {
	margin-top: 10px;
	font-size: 17px;
	text-overflow: hidden;
	text-overflow: ellipsis;
}

.postdetail-info-container {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
	overflow:auto;
	font-size: 15px;
}

.postdetail-info-map {
	width: 100%;
	height: 300px;
	margin: 20px 0;
}

.postdetail-comment-container {
	/* text-align: center; */
	padding: 20px;
	margin: 100px 300px;
}

.postdetail-comment-title {
	display: block;
	color: #000;
	font-size: 30px;
	margin-bottom: 20px;
}

.postdetail-comment-title  span {
	color: #2986FF;
}

.postdetail-comment-form-container {
	background-color: #CDECFF;
	padding: 20px;
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

 .postdetail-comment-btn-wrap {
	text-align: right;
 }

.postdetail-post-area {
	margin-bottom: 10px;
	display: flex;
	
}


 /* 댓글 창 디자인 */
.comment-box {
	display: grid;
	grid-template-columns: 100px 1fr;
	padding: 30px 20px;
	border-bottom: 1px solid #939393;
}

 .comment-img {
	border-radius: 50%;
 }

 .comment-created > span {
	margin-right: 20px;
 }

 .comment-name {
	font-weight: 500;
 }

 .comment-date {
	color: #939393;
	font-size: 15px;
 }

.bottom-btn {
	display: flex;
	justify-content: center;
}

 .btn-more {
	margin-top: 20px;
 }
</style>