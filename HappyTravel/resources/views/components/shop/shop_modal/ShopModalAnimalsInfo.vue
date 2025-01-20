<template>
	<div class="animalsInfo-container">
		<div class="animalsInfo-title">
			<p>예약자 추가 정보 입력</p>
		</div>
		<div class="animalsInfo-form-container">
			<div class="animalsInfo-form-buttonArea">
				<button @click="discountAnimalInfo()">-</button>
				<button @click="addAnimalInfo()">+</button>
			</div>
			<div class="animalsInfo-formArea">
				<div class="animalsInfo-form" v-for="(animalInfo, i) in animalInfos" :key="i">
					<div class="animalsInfo-form-type inner">
						<label for="animalType">동물 종류</label>
						<select v-model="animalInfo.animalType" name="animalType" id="animalType">
							<option value="소형견">소형견</option>
							<option value="중형견">중형견</option>
							<option value="대형견">대형견</option>
							<option value="고양이">고양이</option>
							<option value="조류">조류</option>
						</select>
					</div>
					<div class="animalsInfo-precautions inner">
						<label for="animalPrecautions">주의사항</label>
						<textarea v-model="animalInfo.animalPrecautions" name="animalPrecautions" id="animalPrecautions"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>
import { reactive } from 'vue';
	const sample =reactive({
		animalType : '소형견'
		,animalPrecautions : ''
	})

	const animalInfos = reactive([{
		animalType : '소형견'
		,animalPrecautions : ''
	}]);

	function addAnimalInfo(){
		animalInfos.push(sample);
	}

	function discountAnimalInfo(){
		if(animalInfos.length === 1){
			alert('최소 한개는 있어야 합니다.');
			return;
		}
		animalInfos.pop();
	}

</script>
<style scoped>
	.animalsInfo-container{
		display: flex;
		flex-direction: column;
		gap : 1rem;

		width: 100%;
		min-height: 100%;
	}
	/* 제목 부분 */
	.animalsInfo-title{
		font-size: 1.5rem;
		font-family: 'GmarketSansBold';
	}
	/* 버튼 부분 */
	.animalsInfo-form-buttonArea{
		display: flex;
		justify-content: flex-start;

		gap:1rem;
	}
	.animalsInfo-form-buttonArea button{
		width: 3rem;
		height: 3rem;
		border-radius: 100%;

		display: flex;
		justify-content: center;
		align-items: center;
	}

	/* 폼 부분 */
	.animalsInfo-form-container{
		width: 100%;
		height: 400px;

		border: 1px solid black;

		padding : 35px 70px;
	}
	.animalsInfo-formArea{
		width: 100%;
		height: 95%;
		overflow: auto;
	}
	.animalsInfo-form{
		display: flex;
		flex-direction: column;;
		width: 100%;
		max-height: 95%;

		border:1px solid black;

		margin: 1rem 0;

		padding : 50px 102px 16px 102px;

		gap:1rem;
	}
	.inner{
		display: flex;
		flex-direction: column;

		align-items: flex-start;
		justify-content: space-between;

		gap: 1rem;
	}
	.animalsInfo-form-type select{
		width: 100%;
		height: 55px;
	}
	.animalsInfo-precautions{
		width: 100%;
		height: 100%;
	}
	.animalsInfo-precautions textarea{
		width: 100%;
		height: 85px;

		resize: none;
	}
</style>