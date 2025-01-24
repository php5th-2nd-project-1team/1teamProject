<template>
	<div class="shop-calander">
		<div class="shop-calander-controller">
			<div></div>
			<div class="shop-btn">
				<button @click="getPrevDate()"><</button>
				<span>{{ activeDate.year }}년 {{ activeDate.month }}월 {{ selectedDate }}일</span>
				<button @click="getNextDate()">></button>
			</div>
			<button @click="setResetDate()">초기화</button>
		</div>
		<div class="shop-calander-date">
			<button class="shop-calander-prev"><</button>
			<Swiper
			:modules="modules"
			:navigation="{ nextEl:'.shop-calander-next', prevEl:'.shop-calander-prev'  }"
			:key="swiperKey"
			:slides-per-view="15"
			:space-between="30"
			>
				<SwiperSlide v-for="i in activeDate.day"
						:key="`${activeDate.year}-${activeDate.month}-${i.day}`" 
						@click="onClickDay(i.day)"
						:class="{
							holiday: i.weekday % 7 === 0,
							weekend: i.weekday % 7 === 6,
							// today: i.day === selectedDate
							}">
					<!-- <div class="swiper-slide" v-if="i.weekday%7 === 0">
						<p>{{ week(i.weekday) }}</p>
						<p>{{i.day}}</p>
					</div>
					<div class="swiper-slide" v-else-if="i.weekday%7 === 6">
						<p>{{ week(i.weekday) }}</p>
						<p>{{i.day}}</p>
					</div> -->
					<div class="swiper-slide">
						<p>{{ week(i.weekday) }}</p>
						<p :class="{today: i.day === selectedDate}">{{i.day}}</p>
					</div>
				</SwiperSlide>
			</Swiper>
			<button class="shop-calander-next">></button>
		</div>
	</div>
</template>
<script setup>
	import { Swiper, SwiperSlide} from 'swiper/vue';
	import { onBeforeMount, reactive, ref } from 'vue';
	import { Navigation } from 'swiper/modules';
	import 'swiper/swiper-bundle.css';
	import { useStore } from 'vuex';
	// swiper 네비게이션
	const modules = [Navigation];

	const store = useStore();

	// 선언 부분
	const swiperKey = ref(null);
	// const mySwiper = ref(null);

	// 여기서부터 달력 출력을 위한 환장쇼
	const activeDate = reactive({
		year : 0
		,month : 0
		,day : [

		]
	});

	const currentMonth = new Date().getMonth() + 1;
	const currentYear = new Date().getFullYear();

	const date = new Date();

	const month = String(date.getMonth() + 1).padStart(2, '0'); // 월에 0을 붙임
  	const currentDay = String(date.getDate()).padStart(2, '0'); // 일에 0을 붙임

	const selectedDate = ref(currentDay);

	
	function selectDate(day) {
  		selectedDate.value = day;
	};

	function setResetDate() {
		setActiveDate(currentYear, currentMonth);
		const currentReset =currentYear + '-' + month + '-' + currentDay;
		store.commit('shop/setCurrentPage', 0); // 페이지 초기화
		store.dispatch('shop/shopBoardList', currentReset);
	}
	
	console.log(currentDay);

	// 월 일 계산해서 집어넣는 함수 
	function setActiveDate(p_year, p_month){
		let month = p_month;
		let year = p_year;

		// 만약 month가 13 이상이면 그만큼 빼고 year 1 증가
		if(month > 12){
			month -= 12;
			year ++; 
		} 
		// 만약 month가 0 이하라면, 그만큼 더하고 year 1 감소
		else if(month < 1){
			month += 12;
			year --;
		}

		// 총 월 계산
		const targetDate = new Date(year, month, 0);
		const totalDays = targetDate.getDate(); 

		activeDate.year = targetDate.getFullYear();
		activeDate.month = targetDate.getMonth() + 1;

		activeDate.day.length = 0;

		// 1일부터 마지막 날까지 반복
		for (let day = 1; day <= totalDays; day++) {
			// 요일 계산
			const weekday = new Date(year, month - 1, day).getDay();

			// 요일에 따라 색상 설정
			let dayInfo = {
				day: day,
				weekday: weekday,
			};

			activeDate.day.push(dayInfo);
		}

		swiperKey.value ++;
		selectDate(currentDay);
	}

	// 이동 가능 여부
	function isMoveable(targetMonth){
		if(currentMonth > targetMonth) return false;
		if(currentMonth + 2 < targetMonth ) return false;

		return true;
	}

	// 다음 달, 이전 달로 이동
	function getNextDate(){
		if(isMoveable(activeDate.month + 1)){
			setActiveDate(activeDate.year, activeDate.month + 1);
			selectDate(1);
			const currentNextDate = `${activeDate.year}-${activeDate.month}-${selectedDate.value}`;
			store.commit('shop/setCurrentPage', 0); // 페이지 초기화
			store.dispatch('shop/shopBoardList', currentNextDate);
		}
	}

	function getPrevDate(){
		if(isMoveable(activeDate.month - 1)){
			setActiveDate(activeDate.year, activeDate.month - 1);
			selectDate(1);
			const currentPrevDate = `${activeDate.year}-${activeDate.month}-${selectedDate.value}`;
			store.commit('shop/setCurrentPage', 0); // 페이지 초기화
			store.dispatch('shop/shopBoardList', currentPrevDate);
		}
	}

	// 클릭하면 클릭한 년, 월, 일 출력
	function onClickDay(day){
		const currentDay = `${activeDate.year}-${activeDate.month}-${day}`;
		selectDate(day);
		store.commit('shop/setCurrentPage', 0); // 페이지 초기화
		store.dispatch('shop/shopBoardList', currentDay);
	}

	function week(num){
		const week = ['일', '월', '화', '수', '목', '금', '토'];
		return week[num%7];
	}

	onBeforeMount(() => {
		setActiveDate(currentYear, currentMonth);
		const current = currentYear + '-' + month + '-' + currentDay;
		console.log(current);
		store.dispatch('shop/shopBoardList', current);
	});
</script>
<style scoped>
	.shop-calander{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        padding : 1rem;

        width: 100%;

		gap:2rem;

		border: 1px solid #000;

		border-radius: 10px;

		background-color: rgb(200, 200, 200);
    }
	.shop-calander-controller{
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap : 1rem;

		width: 100%;
	}
	.shop-calander-controller button{
		width: 3rem;
		height: 3rem;

		border-radius: 100%;
	}
    .shop-calander-date{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap : 1rem;

		width: 100%;

		border: 1px solid rgb(0, 0, 0);
		border-radius: 10px;

		background-color: white;

		padding : 1rem;
    }
	.shop-calander-date button{
		width: 4rem;
		height: 2rem;

		border-radius: 100%;
	}
	.shop-btn {
		display: flex;
		justify-content: center;
		align-items: center;
		
		gap: 1rem;

		margin-left: 60px;
	}
	.swiper-slide{
		cursor: pointer;

		display: flex;
		flex-direction: column;
		gap : 1rem;
	}

	.holiday{
		color: #f00;
	}
	.weekend{
		color: #00f;
	}
	.today {
		font-size: 30px;
	}
</style>