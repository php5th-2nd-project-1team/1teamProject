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
				<div class="community-card-content">
					<img class="community-card-img" src="/developImg/about-three2.png" alt="">
				</div>

			</div>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.community-card-content {
		width: 100%;
		height: 100%;
	}

	.community-card-img {
		width: 100%;
		height: 100%;
		border-radius: 50px;
		padding: 15px 0;
	}
</style>