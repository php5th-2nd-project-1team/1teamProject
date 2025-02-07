<template>
	<div class="index-postbox">
		<div class="index-postbox-title">
			<h3>커뮤니티 반려동물 자랑</h3>
			<p>#귀여운 댕댕이의 멋진 모습을 자랑해주세요</p>
			<div class="index-controller">
				<button><</button>
				<button>></button>
			</div>
		</div>
		<div class="index-cardzone">
			<div class="index-card" v-for="value in 4" :key="value">
				<div class="index-card-img">
					<div class="index-card-img-content">
						<img src="/developImg/shop_detail1.png" alt="">
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