import axios from '../../axios';
import router from '../../router';
import store from '../store';

export default {
	namespaced: true,
	state: () => ({
        loadingFlg: false,
        modalFlg: false,
	})
	,mutations: {
        setLoadingFlg(state, loadingFlg) {
            state.loadingFlg = loadingFlg;
        },
        setModalFlg(state, modalFlg) {
            state.modalFlg = modalFlg;
        },
	}
	,actions: {
        // 유저 마이페이지 처리
        userDetailPage(context, id) {
            context.commit('setLoadingFlg', true);
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                const url  = '/api/user/mypage/' + id;
                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }
                
                axios.get(url, config)
                .then(response => {
                    context.commit('setLoadingFlg', false);
                })
                .catch(error => {
                    console.error(error);

                    context.commit('setLoadingFlg', false);
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
                formData.append('post_code', detailUserInfo.post_code);
                formData.append('detail_address', detailUserInfo.detail_address);
                formData.append('file', detailUserInfo.file);

                axios.post(url, formData, config)
                .then(response => {
                    // console.log(response.data);
                    localStorage.setItem('userInfo', JSON.stringify(response.data.userInfo));
                    context.commit('auth/setUserInfo', response.data.userInfo, {root: true});
                    alert('수정 완료했습니다.');

                    router.replace('/user/mypage');
                })
                .catch(error => {
                    console.error(error.response.data); // 오류 메시지 확인
                    let errorMsgList = [];
                    const errorData = error.response.data;
                    if(error.response.status === 422) {
                        if(errorData.data.name) {
                            errorMsgList.push('이름은 2~4글자의 한글만 입력 가능합니다.');
                        }
                        if(errorData.data.nickname) {
                            errorMsgList.push('닉네임은 영어, 숫자, 한글만 가능하며 최대 8자리까지 입력 가능합니다.');
                        }
                        if(errorData.data.address) {
                            errorMsgList.push('주소는 한글과 숫자만 가능하며 최대 20자리까지 입력 가능합니다.');
                        }
                        if(errorData.data.detail_address) {
                            errorMsgList.push('상세주소는 한글과 숫자만 가능하며 최대 20자리까지 입력 가능합니다.');
                        }
                        if(errorData.data.phone_number) {
                            errorMsgList.push('전화번호는 010-0000-0000 형식으로 입력해야 합니다.');
                        }
                    }else{
                        alert('알 수 없는 에러입니다.')
                    }
    
                    alert(errorMsgList.join('\n'));
                });
            }, {root: true});
        },

        // 비밀번호 체크 처리
        userPasswordChk(context, userInfo) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
            
                const url = '/api/user/withdraw';

                const data = JSON.stringify(userInfo);

                // console.log(userInfo);

                axios.post(url, data)
                .then(response => {
                    router.replace('/user/mypage/update');
                })
                .catch(error => {
                    alert('비밀번호가 일치하지 않습니다.');
                });
            }, {root: true});
        },

        PasswordUpdateChk(context, userInfo) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
            
                const url = '/api/user/withdraw';

                const data = JSON.stringify(userInfo);

                // console.log(userInfo);

                axios.post(url, data)
                .then(response => {
                    router.replace('/user/mypage/password/update');
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        alert('비밀번호가 일치하지 않습니다.');
                    }
                });
            }, {root: true});
        },
        

        userDeletePasswordChk(context, userInfo) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
            
                const url = '/api/user/withdraw';

                const data = JSON.stringify(userInfo);


                axios.post(url, data)
                .then(response => {
                    context.commit('setModalFlg', true);
                })
                .catch(error => {
                    alert('비밀번호가 일치하지 않습니다.');
                    context.commit('setModalFlg', false);
                });
            }, {root: true});
        },

        userDelete(context, id) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                // console.log(id);
                const url = '/api/user/withdraw/' + id;

                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }

                axios.post(url, config)
                .then(response => {
                    // Auth 플레그 했던 거 지우기
                    context.commit('auth/setAuthFlg', false, {root: true});
                    context.commit('auth/setUserInfo', {}, {root: true});

                    // 로컬 스토리지 비우기
                    localStorage.clear();

                    alert('회원탈퇴 처리가 완료되었습니다.');
                    // index 페이지로 이동
                    router.replace('/');
                })
                .catch(error => {
                    alert('오류로 인해 회원탈퇴 처리를 못 했습니다.');
                    console.error(error);
                });
            }, {root: true});
        },

        myPasswordUpdate(context, userInfo) {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                const url = '/api/mypage/password/update'

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };

                // form data 세팅
                const formData = new FormData();
                formData.append('user_id', userInfo.user_id);
                formData.append('password', userInfo.password);
                formData.append('passwordChk', userInfo.passwordChk);

                axios.post(url, formData, config)
                .then(response => {
                    // console.log(response.data);
                    alert('비밀번호 변경 완료했습니다.');

                    router.replace('/user/mypage');
                })
                .catch(error => {
                    console.error(error.response.data); // 오류 메시지 확인
                    if(error.response.status === 422) {
                        if(error.response.data.data.passwordChk) {
                           alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
                        }
                    }else if (error.response.status === 403) {
                        alert('이전과 동일한 비밀번호는 사용할 수 없습니다. 다른 비밀번호를 입력해주세요.');
                    }
                    else{
                        alert('알 수 없는 에러입니다.')
                    }
    
                });
            }, {root: true});
        },
    }
	,getters: {
		
	}
}