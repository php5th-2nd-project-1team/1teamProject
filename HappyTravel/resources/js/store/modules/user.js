import axios from '../../axios';
import router from '../../router';

export default {
	namespaced: true,
	state: () => ({
        allUserInfo: {},
        loadingFlg: false,
	})
	,mutations: {
        setAllUserInfo(state, allUserInfo) {
            state.allUserInfo = allUserInfo;
        },
        setLoadingFlg(state, loadingFlg) {
            state.loadingFlg = loadingFlg;
        }
	}
	,actions: {
        // 유저 마이페이지 처리
        userDetailPage(context, id) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                context.commit('setLoadingFlg', true);
                const url  = '/api/user/mypage/' + id;
                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }
                
                axios.get(url, config)
                .then(response => {
                    console.log(response.data);
                    context.commit('setAllUserInfo', response.data.user);
                    
                    
                    context.commit('setLoadingFlg', false);
                })
                .catch(error => {
                    console.error(error);
                })
                
                
            }, {root: true});
        },

        // 비밀번호 체크 처리
        userPasswordChk(context, userInfo) {
            const url = '/api/login';

            const data = JSON.stringify(userInfo);

            axios.post(url, data)
            .then(response => {
                alert('비밀번호 확인 성공했습니다.')

                router.replace('/mypage/auth/update');
            })
            .catch(error => {
                alert('비밀번호가 맞지 않습니다..');
            });
        },
    }
	,getters: {
		
	}
}