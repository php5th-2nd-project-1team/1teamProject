require('./bootstrap');

import { createApp } from 'vue';
import router from './router';
import AppComponent from '../views/components/AppComponent.vue';
import store from './store/store'
import { useKakao } from 'vue3-kakao-maps';

useKakao('88b9686891fe93d8f46cf1e55fa7f3ba');
createApp({
	components:{
		AppComponent
	}
})
.use(store)
.use(router)
.mount('#app');