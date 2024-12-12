import {createStore} from 'vuex';
import post from './modules/post';
import user from './modules/user';

export default createStore({
	modules:{
		post,
		user
	},
});