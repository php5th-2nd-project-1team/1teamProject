import axios from '../../axios';
import router from '../../router';

export default {
	namespaced: true,
	state: () => ({
        loadingFlg: false,
	})
	,mutations: {
        setLoadingFlg(state, loadingFlg) {
            state.loadingFlg = loadingFlg;
        },
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
                    console.log('userDetailPage then', response.data);

                    context.commit('setLoadingFlg', false);
                })
                .catch(error => {
                    console.error(error);
                })
                
                
            }, {root: true});
        },

        // 유저 정보 수정 처리
        myPageUpdate(context, detailUserInfo) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                const url = '/api/mypage/auth/update'
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };

                // form data 세팅
                const formData = new FormData();
                formData.append('user_id', detailUserInfo.user_id);
                formData.append('nickname', detailUserInfo.nickname);
                formData.append('name', detailUserInfo.name);
                formData.append('phone_number', detailUserInfo.phone_number);
                formData.append('address', detailUserInfo.address);
                formData.append('detail_address', detailUserInfo.detail_address);
                formData.append('file', detailUserInfo.file);

                axios.post(url, formData, config)
                .then(response => {
                    console.log(response.data);
                    localStorage.setItem('userInfo', JSON.stringify(response.data.userInfo));
                    context.commit('auth/setUserInfo', response.data.userInfo, {root: true});
                    alert('수정 완료했습니다.');

                    router.replace('/user/mypage');
                })
                .catch(error => {
                    alert('수정에 실패했습니다.');
                });
            }, {root: true});
        },

        // 비밀번호 체크 처리
        userPasswordChk(context, userInfo) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
            
                const url = '/api/user/withdraw';

                const data = JSON.stringify(userInfo);

                axios.post(url, data)
                .then(response => {
                    router.replace('/mypage/auth/update');
                })
                .catch(error => {
                    alert('비밀번호가 일치하지 않습니다.');
                });
            }, {root: true});
        },

        userDelete(context, id) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                const url = '/api/user/withdraw/' + id;

                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }

                axios.post(url, config)
                .then(response => {
                    alert('회원탈퇴 처리 완료했습니다.');
                    // 로컬 스토리지 비우기
                    localStorage.clear();

                    // Auth 플레그 했던 거 지우기
                    context.commit('auth/setAuthFlg', false);
                    context.commit('auth/setUserInfo', {});

                    router.replace('/index');
                })
                .catch(error => {
                    alert('오류로 인해 회원탈퇴 처리를 못 했습니다.');
                    console.error(error);
                });
            }, {root: true});
        }
    }
	,getters: {
		
	}
}