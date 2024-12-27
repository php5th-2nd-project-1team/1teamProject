require('./bootstrap');

import { createApp } from 'vue';
import router from './router';
import AppComponent from '../views/components/AppComponent.vue';
import store from './store/store'
import { useKakao } from 'vue3-kakao-maps';

useKakao('5499095a710d76a06d421cdb1cb7efb2');
createApp({
	components:{
		AppComponent
	}
})
.use(store)
.use(router)
.mount('#app');