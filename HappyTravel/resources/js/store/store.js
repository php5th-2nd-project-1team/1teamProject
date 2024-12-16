import {createStore} from 'vuex';
import post from './modules/post';
import user from './modules/user';
import notice from './modules/notice';
import auth from './modules/auth';

export default createStore({
	modules:{
		post,
		user,
		notice,
		auth,
	},
});