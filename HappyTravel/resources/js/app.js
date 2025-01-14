require('./bootstrap');

import { createApp } from 'vue';
import router from './router';
import AppComponent from '../views/components/AppComponent.vue';
import store from './store/store'
import { useKakao } from 'vue3-kakao-maps';

useKakao('d0956fc225a54a34d5f36bcd17914798');
createApp({
	components:{
		AppComponent
	}
})
.use(store)
.use(router)
.mount('#app');