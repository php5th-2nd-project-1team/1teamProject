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
                    console.log('userDetailPage then', response.data);

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

                axios.post(url, data)
                .then(response => {
                    router.replace('/mypage/auth/update');
                })
                .catch(error => {
                    alert('비밀번호가 일치하지 않습니다.');
                });
            }, {root: true});
        },

        // 아이디 중복 체크 
        userIdCheck(context, userId) {
            const url = '/api/userIdCheck';

            const data = JSON.stringify(userId);

            console.log(userId);

            axios.post(url, data)
            .then(response => {
                console.log(response.data);
                alert('사용 가능한 아이디입니다.');
            })
            .catch(error => {
                let errorMsgList = [];
                const errorData = error.response.data;

                if(error.response.status === 422) {
                    console.log(errorData.data.account)
                    if(errorData.data.account) {
                        errorMsgList.push(errorData.data.account[0]);
                    }
                    alert(errorMsgList.join('\n'));
                }else if(error.response.status === 402) {
                    alert('이미 사용중인 아이디입니다.');
                }
                
            });
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