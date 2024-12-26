<template>
	<div class="about-container">
		<!-- 팻브리즈 소개 -->
		<div class="about-introduce">
			<div>
				<h1>펫브리즈 소개</h1>
				<iframe src="https://www.youtube.com/embed/mTF9Yjszwx4?si=z6KjuXvEmH21F_gq" 
				title="YouTube video player" 
				frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
				referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			</div>
		</div>

		<!-- 중간 코멘트 -->
		<div class="about-comment">
			<h1>펫브리즈 반려동물과 함께 여행을 떠나자</h1>
			<div class="about-comment-grid">
				<h2>목적</h2>
				<p>반려동물과 함께 할 수 있는 여행지 소개하기</p>
			</div>
			<div class="about-comment-grid">
				<h2>과정</h2>
				<p>자료조사를 통해 반려동물 동반 가능한 <br>여행치 탐색하기</p>
			</div>
			<div class="about-comment-grid">
				<h2>바램</h2>
				<p>21세기 반려동물이 항상 함께하는 만큼<br>좋은 장소가 많았으면!</p>	
			</div>
		</div>

		<!-- 좋은 점 3가지 -->
		<hr>

		<div class="about-three">
			<h1>"펫브리즈"의 좋은 3가지</h1>
			<p class="about-three-comment"><span>팻브리즈</span>는 무슨 좋은 점을 가지고 있을까요? 한 번 알아봅시다!</p>
			<div class="about-three-picture-box">
				<div class="about-three-picture" style="background-image: url('/developImg/about-three1.png');">
					<div class="about-three-picture-comment">
						<h2>편리함</h2>
						<p>반려동물과 함께할 여행지를 쉽게 찾을 수 있습니다.</p>
					</div>
				</div>
				<div class="about-three-picture" style="background-image: url('/developImg/about-three2.png');">
					<div class="about-three-picture-comment">
						<h2>소통</h2>
						<p>여행 경험을 공유하고 다른 애호가와 소통할 수 있습니다.</p>
					</div>
				</div>
				<div class="about-three-picture" style="background-image: url('/developImg/about-three3.png');">
					<div class="about-three-picture-comment">
						<h2>안전함</h2>
						<p>안전하고 편안한 장소만을 엄선하여 제공합니다.</p>
					</div>
				</div>
			</div>
		</div>

		<!-- 마무리 코멘트 -->
		<div class="about-final">
			<p>귀여운 1조와 함께 만드는 <span>“펫브리즈”</span>는</p>
			<p>반려동물여행의 지역별, 분야별 여행지를 소개하고 공유하는 공간입니다.</p>
			<br>
			<p>반려동물 동반 업체의 사장님이시라면 멍멍냥냥을 통해 홍보를!</p>
			<p>여행을 준비하는 반려인이라면 다양한 여행 코스를 계획해보세요.</p>
			<br>
			<p>내가 만든 여행코스를 친구들과 공유하고, 기록해 두었다가 다음 여행시 참고할 수 있는</p>
			<p>반려동물 여행의 모든 것이 다~ 있는 곳.</p>
			<br>
			<p>1조 펫브리즈과 함께 여행이라는 추억을 선물 하세요.</p>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.about-container{
		display: flex;
		flex-direction: column;
		align-items: center;

		gap:40px;

		padding: 0 200px;
	}

	iframe{
		width: 50%;
		height: 80%;
	}

	/* 팻브리즈 소개 */
	.about-introduce{
		width: 100%;
		display: flex;
		flex-direction: column;

		align-items: center;
	}

	
	.about-introduce div{
		width: 100%;
		height: 500px;
		background-image: url('/developImg/about-sample-bg.png');
		
		display: flex;
		justify-content: center;
		align-items: center;
		
		position: relative;
	}
	.about-introduce h1{
		position: absolute;
		top: -5%;
	}
	
	/* 중간 코멘트 */
	.about-comment{
		display: flex;
		flex-direction: column;
		align-items: center;

		text-align: center;
		gap: 1rem;
	}

	.about-comment h1{
		margin-bottom: 42px;
	}

	.about-comment-grid{
		display: grid;
		grid-template-columns: 1fr 3fr;

		border: 1px solid black;
		border-radius: 10px;

		width: 100%;
		height: 120px;

		align-items: center;			
	}

	.about-comment-grid h2{
		font-size: 30px;
		background-color: #2986FF;
		color : white;
		border-top-left-radius: 10px;
		border-bottom-left-radius: 10px;

		width: 100%;
		height: 100%;
		
		display: flex;
		justify-content: center;
		align-items: center;

		font-size: 1.4rem;
	}

	.about-comment p{
		font-size: 20px;
	}
	/* 좋은 점 3가지 */

	hr{
		width: 80%;
	}

	.about-three{
		display: flex;
		flex-direction: column;

		align-items: center;
		text-align: center;

		width: 100%;
	}
	
	.about-three-comment{
		font-size: 20px;
	}
	.about-three-comment span{
		font-weight: 900;
	}

	.about-three-picture-box{
		margin-top: 40px;

		width: 100%;
		background-color: #2986FF;

		height: 400px;

		display: grid;
		grid-template-columns: repeat(3 , 1fr);
		justify-items: center;
		align-items: center;
	}

	.about-three-picture{
		width: 80%;
		height: 80%;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		border-radius: 50px;
	}

	.about-three-picture:hover .about-three-picture-comment{
		display: flex;

		flex-direction: column;
		justify-content: center;
		align-items: center;
		gap: 20px;

		width: 100%;
		height: 100%;

		color: white;

		background-color: rgb(0, 0, 0, 0.7);

		text-align: center;

		padding: 30px;

		border-radius: 50px;
	}

	.about-three-picture-comment{
		display: none;
	}

	.about-three-picture-comment p{
		font-size: 1.5rem;
	}

	.about-three-picture-comment h2{
		font-size: 2.5rem;
	}

	/* 반응형 부분 */

	@media (max-width : 1024px){
		.about-container{
			padding: 0 50px;
		}

		.about-three-picture-box{
			grid-template-rows: repeat(3 , 1fr);

			grid-template-columns: none;

			height: 600px;
		}
	}
</style>