<template>
	<div class="clientinfo-container">
		<div class="clientinfo-title">
			<p>예약자 정보 확인</p>
		</div>
		<div class="clientinfo-name">
			<p>예약자 성함</p>
			<input type="text" name="name" id="name" value="김룹뿡" readonly>
		</div>
		<div class="clientinfo-phone">
			<p>연락 가능한 연락처</p>
			<input type="text" name="phone" id="phone" value="010-1234-5678" readonly>
		</div>
		<div class="clientinfo-count">
			<p>참여 인원 수</p>
			<button><</button>
			<input type="number" name="count" id="count" value="1">
			<button>></button>
		</div>
		<div class="clientinfo-price">
			<p>결제 금액</p>
			<p>100,000원</p>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	/* input:number 상하 화살표 제거하는 코드 */
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
</style>