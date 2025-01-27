<template>
	<div class="admin-posts-detail-container">
		<h1>포스트 수정</h1>
		<div>
			<p>해당 포스트 사이트로 이동 : <span>여기에 url 입력</span></p>
		</div>
		<div>
			<label for="title">제목 : </label>
			<input type="text" id="title">
		</div>
		<div>
			<p>입장 가능한 동물 종류</p>
			<input type="checkbox" id="small_dog" value="소형견">
			<label for="small_dog">소형견</label>
			<input type="checkbox" id="medium_dog" value="중형견">
			<label for="medium_dog">중형견</label>
			<input type="checkbox" id="large_dog" value="대형견">
			<label for="large_dog">대형견</label>
			<input type="checkbox" id="cat" value="고양이">
			<label for="cat">고양이</label>
			<input type="checkbox" id="bird" value="조류">
			<label for="bird">조류</label>
		</div>
		<div>
			<p>시설 기능</p>
			<input type="checkbox" id="pet_menu" value="펫메뉴">
			<label for="pet_menu">펫메뉴</label>
			<input type="checkbox" id="pet_cafe" value="펫카페">
			<label for="pet_cafe">펫카페</label>
			<input type="checkbox" id="pet_hotel" value="펫호텔">
			<label for="pet_hotel">펫호텔</label>
			<input type="checkbox" id="pet_fitness" value="펫피트니스">
			<label for="pet_fitness">펫피트니스</label>
			<input type="checkbox" id="pet_beauty" value="펫미용">
			<label for="pet_beauty">펫미용</label>
			<input type="checkbox" id="pet_catholic" value="펫카톨릭">
			<label for="pet_catholic">펫카톨릭</label>
		</div>
		<div>
			<label for="local">지역 : </label>
			<select name="local" id="local">
				<option value="서울">서울</option>
				<option value="경기">경기</option>
				<option value="인천">인천</option>
				<option value="부산">부산</option>
				<option value="대구">대구</option>
				<option value="대전">대전</option>
			</select>
		</div>
		<div>
			<label for="content">테마 : </label>
			<select name="theme" id="theme">
				<option value="01">테마1</option>
				<option value="02">테마2</option>
				<option value="03">테마3</option>
				<option value="04">테마4</option>
			</select>
		</div>
		<div>
			<label for="local-detail">지역 상세 : </label>
			<input type="text" id="local-detail">
		</div>
		<div>
			<label for="comment">내용 요약 : </label>
			<input type="text" id="comment">
		</div>
		<div>
			<label for="content">내용 : </label>
			<textarea name="content" id="content"></textarea>
		</div>
		<div class="images">
			<label for="image">이미지 : </label>
			<input type="file" id="image" @change="onChangePicture">
			<img :src="image" alt="">
		</div>
		<div class="images">
			<label for="detailImg1">상세 이미지1 : </label>
			<input type="file" id="detailImg1">
			<img src="" alt="">
		</div>
		<div class="images">
			<label for="detailImg2">상세 이미지2 : </label>
			<input type="file" id="detailImg2">
			<img src="" alt="">
		</div>
		<div class="images">
			<label for="detailImg3">상세 이미지3 : </label>
			<input type="file" id="detailImg3">
			<img src="" alt="">
		</div>
		<div>
			<label for="address">주소 : </label>
			<input type="text" id="address">
		</div>
		<div>
			<label for="lat">위도 : </label>
			<input type="text" id="lat">
		</div>
		<div>
			<label for="lng">경도 : </label>
			<input type="text" id="lng">
		</div>
		<div>
			<p>포스트 지역 정보</p>
			<div>
				<div>
					<label for="phone">전화번호 (없으면 비워둘 것) : </label>
					<input type="tel" id="phone">
				</div>
				<div>
					<label for="homepage">홈페이지 : </label>
					<input type="text" id="homepage">
				</div>
				<div>
					<label for="use-time">이용시간 : </label>
					<input type="text" id="use-time">
				</div>
				<div>
					<label for="payment">요금 : </label>
					<input type="text" id="payment">
				</div>
				<div>
					<label for="parking">주차가능 : </label>
					<label for="parking">가능</label>
					<input type="radio" name="parking" id="parking" value="가능" disabled checked>
					<label for="parking">불가능</label>
					<input type="radio" name="parking" id="parking" value="불가능" disabled>
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>
	import { ref } from 'vue';
	const image = ref(null);

	function onChangePicture(e){
		image.value = URL.createObjectURL(e.target.files[0]);

		console.log(image);
	}
</script>
<style scoped>
	.admin-posts-detail-container{
		width: 100%;
		min-height: 100%;

		padding : 1rem;

		display: flex;
		flex-direction: column;
		gap : 1rem;
	}

	.images{
		display: flex;
		flex-direction: column;
		gap : 1rem;

		width: 50%;

		height: 250px;

		border: 1px solid #000;

		padding : 1rem;
	}

	.images img{
		width: 125px;
	}

</style>