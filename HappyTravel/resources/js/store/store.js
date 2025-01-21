import {createStore} from 'vuex';
import post from './modules/post';
import user from './modules/user';
import notice from './modules/notice';
import auth from './modules/auth';
import shop from './modules/shop';
import editor from './modules/editor';

export default createStore({
	modules:{
		post,
		user,
		notice,
		auth,
		shop,
		editor,
	},
});