<template>
	<div class="index-container">
		<!-- 이벤트 -->
		<div class="index-eventbox">
			<div class="index-event-controller">
				<div class="index-event-comment">
					<p>즐겁게 반려동물과 여행 시작</p>
				</div>
				<h1>여행여행 반려동물과 즐거운 여행👍</h1>
				<p>자세히 보기</p>
				<div class="index-event-buttonArea">
					<button class="index-event-nextbtn">←</button>
						<button class="index-event-btn" v-for="value in 5" :key="value"></button>
					<button class="index-event-nextbtn">→</button>
				</div>
			</div>
			<div class="index-event-viewer">
				<div class="index-event-img" style="background-image: url('/developImg/index-event-sample.png');">
				</div>
			</div>
		</div>

		<!-- 코멘트 박스 -->
		<div class="index-commentbox">
			<p>펫브리즈</p>
			<p>반려동물과 함께 여행을 떠나자</p>
			<p>"왈왈 으르렁 컹컹"</p>
		</div>

		<!-- 유튜브 영상 -->
		<div class="index-mediabox">
			<iframe width="1120" height="630" src="https://www.youtube.com/embed/4Yd7hXtwhDU?si=HvwyEkjoby6blbKn" title="YouTube video player" frameborder="0" 
			allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
			referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			<p>멍멍냥냥멍멍냥냥멍멍냥냥멍멍냥멍멍냥<br>반려동물과 함께 여행을</p>
			<button>더 알아보기</button>
		</div>

		<!-- 여행지 포스트 -->
		<div class="index-postbox">
			<div class="index-postbox-title">
				<h3>미리보는 여행지</h3>
				<p>#귀여운 반려동물과 즐거운 여행을</p>
			</div>
			<div class="index-category">
				<div class="index-category-category">
					<p>숙소</p>
					<p>식음료</p>
					<p>관광지</p>
					<p>동물병원</p>
				</div>
				<div class="index-controller">
					<button><</button>
					<button>></button>
				</div>
			</div>
			<div class="index-cardzone">
				<div class="index-card" v-for="value in 4" :key="value">
					<div class="index-card-img"></div>
					<div class="index-card-hoverShowing">
						<div class="index-card-content">
							<p>댕댕냥냥</p>
						</div>
						<div class="index-card-btnArea">
							<button></button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- 여행지 상품 -->
		<div class="index-postbox">
			<div class="index-postbox-title">
				<h3>개 끝내주는 상품</h3>
				<p>#원하시는 상품을 찾아보세요</p>
			</div>
			<div class="index-category">
				<div class="index-category-category">
					<p>숙소</p>
					<p>식음료</p>
					<p>관광지</p>
					<p>동물병원</p>
				</div>
				<div class="index-controller">
					<button><</button>
					<button>></button>
				</div>
			</div>
			<div class="index-cardzone">
				<div class="index-shop-card" v-for="value in 3" :key="value">
					<div class="index-shop-card-img">
						<p>sale</p>
						<p>new</p>
					</div>
					<p>상품이름</p>
					<p class="abc" data-descr="100,000원">200,000원</p>
					<div class="index-card-btnArea">
					</div>
				</div>
			</div>

		</div>

		<!-- 반려동물 자랑 -->
		<div class="index-postbox">
			<div class="index-postbox-title">
				<h3>커뮤니티 반려동물 자랑</h3>
				<p>#귀여운 댕댕이의 멋진 모습을 자랑해주세요</p>
			</div>
			<div class="index-category-onlyController">
				<div class="index-controller">
					<button><</button>
					<button>></button>
				</div>
			</div>
			<div class="index-community-cardzone">
				<div class="index-community-card" v-for="value in 4" :key="value">
					<div class="index-community-card-img"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>

</script>

<style scoped>
	.abc[data-descr]::after{
		content: attr(data-descr);
		text-decoration: line-through;
	}

	/* 전체 컨테이너 */
	.index-container{
		display: flex;
		flex-direction: column;
		align-items: center;

		gap:40px;

		padding: 0 200px;
	}

	/* 이벤트 박스 */
	.index-eventbox{
		width: 80%;
		height: 500px;  
		background: linear-gradient(#D2EEFF, #92D4FF);

		display: grid;
		grid-template-columns: 1fr 2fr;

		border-radius: 80px;

		padding: 0 2rem;
	}

	.index-event-controller{
		display: flex;
		flex-direction: column;
		justify-content: center;

		gap: 10px;

		padding-left: 16px;
	}

	.index-event-comment{
		background-color: black;
		color: white;
		width: 250px;
		height: 32px;
		display: flex;
		justify-content: center;
		align-items: center;

		border-radius: 200px;
		border-bottom-left-radius: 0%;
	}

	.index-event-buttonArea{
		display: flex;
		justify-content: space-between;
		align-items: center;
		width: 200px;
	}

	.index-event-nextbtn{
		background-color: white;
		border: 0.05px solid black;
		border-radius: 100%;
		font-size: 0.6rem;
		padding: 5px;
	}

	.index-event-btn{
		background: #ECECEC;
		width: 1.2rem;
		height: 1.2rem;
		border: none;
		border-radius: 100%;
	}

	.index-event-activebtn{
		background-color: #2986FF;
	}

	.index-event-viewer{
		width: 100%;
		height: 100%;

		padding : 80px;
	}

	.index-event-img{
		background-color: white;
		width: 100%;
		height: 100%;

		border-radius: 50px;

		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}

	/* 코멘트 박스 */
	.index-commentbox{
		display: flex;
		flex-direction: column;
		align-items: center;

		font-weight: 900;
		font-size: 40px;
	}

	.index-commentbox :last-child{
		margin: 20px 0;
	}

	/* 유튜브 영상 */
	.index-mediabox{
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.index-mediabox p{
		text-align: center;
		margin-top: 40px;
		margin-bottom: 20px;
		font-size: 36px;
		font-weight: 500;
	}

	.index-mediabox button{
		background-color: #2986FF;
		border: none;
		border-radius: 500px;
		box-shadow: 0 3px 3px 0.5px black;

		color: white;
		font-size: 2.2rem;

		width: 300px;
		height: 80px;
	}

	.index-mediabox button:hover{
		background-color: rgb(41, 134, 255, 0.8);
		cursor: pointer;

		transition: background-color 0.1s;
	}

	/* 여행지 포스트 */
	.index-postbox{
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		width: 100%;
	}

	.index-postbox-title{
		display: flex;
		gap : 10px;
		padding : 0 100px;
		
		align-items: center;
	}

	.index-postbox-title h3{
		font-size: 36px;
	}

	.index-postbox-title p{
		font-size: 20px;
		color: gray;
	}

	.index-category{
		display: flex;
		justify-content: space-between;
		width: 100%;

		padding : 0 100px;
		margin : 20px 0;
	}

	.index-category-category{
		display: flex;
		gap : 45px;
	}

	.index-category-category p{
		font-size: 20px;
	}

	.index-controller{
		display: flex;
		gap : 10px;
	}

	.index-controller button{
		width: 50px;
		height: 50px;
		display: flex;
		justify-content: center;
		align-items: center;

		background-color: whitesmoke;
		border: none;
		border-radius: 100%;

		font-size: 2rem;
		font-weight: 100;
	}

	.index-controller button:hover{
		background-color: black;
		color: white;
	}

	.index-cardzone{
		width: 100%;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		grid-auto-rows: 400px;

		gap : 30px;

		justify-items: center;
		align-items: flex-end;
	}

	.index-card{
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		background-color: #EFEFEF;
		border-radius: 50px;
		width: 90%;
		height: 90%;
		padding : 10px 25px;
	}

	.index-card:hover {
		width: 100%;
		height: 100%;
		background-color: #2986FF;

		transition: all 0.1s ease-in;
	}

	.index-card:hover .index-card-img{
		padding-top: 80%;

		transition: all 0.1s ease-in;
	}

	.index-card:hover .index-card-hoverShowing{
		display: block;

		transition: all 0.1s ease-in;
	}

	.index-card-img{
		border-radius: 50px;
		padding-top: 100%;
		background-color: black;
	}

	.index-card-hoverShowing{
		display: none;
	}

	.index-card-content{
		font-size : 1.2rem;
		color: white;
	}

	.index-card-btnArea{
		display: flex;
		justify-content: flex-end;
	}

	.index-card-btnArea button{
		background-image: url('/developImg/sample-post.png');
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;

		width: 50px;
		height: 50px;
		border: none;
		border-radius: 100%;
	}

	/* 여행지 상품 */
	.index-shop-card{
		border-radius: 50px;
		width: 100%;
		height: 100%;

		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.index-shop-card-img{
		display: flex;
		width: 100%;
		padding-bottom: 40%;
		border-radius: 50px;

		justify-content: flex-end;

		background-color: rgb(73, 63, 54);

		margin-bottom: 20px;
	}

	.index-shop-card-img p{
		color: white;
		background-color: orange;

		border-radius: 100%;

		width: 3rem;
		height: 3rem;

		margin : 15px 10px;

		display: flex;
		justify-content: center;
		align-items: center;

		line-height: 16px;
	}

	/* 반려동물 자랑 */
	.index-category-onlyController{
		width: 100%;
		display: flex;
		justify-content: flex-end;

		padding : 0 100px;
		margin : 20px 0;
	}

	.index-community-cardzone{
		width: 100%;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		grid-auto-rows: 300px;

		gap : 30px;

		justify-items: center;
		align-items: flex-end;
	}

	.index-community-card{
		width: 100%;
		height: 100%;
	}

	.index-community-card-img{
		width: 100%;
		height: 100%;

		background-color: beige;

		border-radius: 50px;
	}

</style>