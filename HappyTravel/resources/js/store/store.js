import {createStore} from 'vuex';
import post from './modules/post';
import user from './modules/user';
import notice from './modules/notice';

export default createStore({
	modules:{
		post,
		user,
		notice,
	},
});