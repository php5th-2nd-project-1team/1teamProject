<template>
	<div class="index-postbox">
		<div class="index-postbox-title">
			<h3>미리보는 여행지</h3>
			<p>#귀여운 반려동물과 즐거운 여행을</p>
		</div>
		<div class="index-category">
			<!-- TODO 반응형으로 공간 줄어들 시 탭 수정 -->
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
</template>
<script setup>

</script>
<style scoped>
	
</style>