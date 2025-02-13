require('./bootstrap');

import { createApp } from 'vue';
import router from './router';
import AppComponent from '../views/components/AppComponent.vue';
import store from './store/store'
import { useKakao } from 'vue3-kakao-maps';
import config from './config';

useKakao(config.KAKAO_JAVASCRIPT_KEY);
createApp({
	components:{
		AppComponent
	}
})
.use(store)
.use(router)
.mount('#app');