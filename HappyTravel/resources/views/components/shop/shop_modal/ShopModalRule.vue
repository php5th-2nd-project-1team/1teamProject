<template>
	<div class="rule-container">
		<div class="rule-title">
			<p>필수 이용약관</p>
			<p2>예약 시, 약관에 동의한 것으로 간주합니다.</p2>
		</div>
		<div class="rule-area">
			<div class="rules" v-for="i in 5" :key="i">
				<p>title{{ i }}</p>
				<div class="rule">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, tempora deleniti? Dicta assumenda, dignissimos quia minus neque exercitationem harum impedit laudantium unde quis aperiam, a consectetur eius ex nesciunt voluptatem?</p>
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>

</script>
<style scoped>
	.rule-container{
		display: flex;
		flex-direction: column;
		gap : 1rem;
	}
	.rule-title{
		display: flex;
		align-items: flex-end;

		font-size: 1.5rem;
		font-family: 'GmarketSansBold';

		gap:1rem;
	}

	.rule-title p2{
		font-size: 1rem;
		color:gray;
	}

	.rule-area{
		width: 100%;
		height: 400px;

		border : 1px solid black;

		overflow: auto;

		padding : 1rem;

		display: flex;
		flex-direction: column;
		gap: 1rem;
	}
	.rules p{
		margin-bottom: 1rem;
	}
	.rule{
		border: 1px solid black;
	}
</style>