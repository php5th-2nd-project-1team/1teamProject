import axios from '../../axios';
import router from '../../router';

export default {
	namespaced: true,
	state: () =>({
        // 로컬 스토리지에 accessToken이 있으면 true, 그렇지 않으면 false
        authFlg: localStorage.getItem('accessToken') ? true : false,
        
        // 로컬 스토리지에 userInfo가 있으면 그대로 저장, 혹은 빈 객체
        userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : {}, 
	})
	,mutations: {
        setAuthFlg(state, flg) {
            state.authFlg = flg;
        },
        
        setUserInfo(state, userInfo) {
            state.userInfo = userInfo;
        },
	}   
	,actions: {
        login(context, userInfo) {
            const url = '/api/login';

            const data = JSON.stringify(userInfo);

            axios.post(url, data)
            .then(response => {
                localStorage.setItem('accessToken', response.data.accessToken);
                localStorage.setItem('refreshToken', response.data.refreshToken);
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setAuthFlg', true);
                context.commit('setUserInfo', response.data.data);

                router.replace('/index');
            })
            .catch(error => {
                console.error(error.response.data); // 오류 메시지 확인
                let errorMsgList = [];
                const errorData = error.response.data;

                if(error.response.status === 500) {
                    errorMsgList.push('알 수 없는 에러');
                }else {
                    errorMsgList.push('아이디 또는 비밀번호가 잘못되었습니다.');
                }

                alert(errorMsgList.join('\n'));
                    
            });
        },

        
         /**
        * 로그아웃 처리
        * @param {*} context
        */
        logout(context)  {
            context.dispatch('auth/chkTokenAndContinueProcess', () => {
                    // TODO : 백엔드 처리 추가
                    const url = '/api/logout';
                    const config = {
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                        }
                    }
                    
                    axios.post(url, null, config)
                    .then(resaponse => {
                        alert('로그아웃이 완료되었습니다.');
                    })
                    .catch(error => {
                        alert('문제가 발생하여 로그아웃 처리');
                    })
                    .finally(() => {
                    // 로컬 스토리지 비우기
                    localStorage.clear();
                    
                    // Auth 플레그 했던 거 지우기
                    context.commit('setAuthFlg', false);
                    context.commit('setUserInfo', {});
                    
                    router.replace('/login');
                });
            }, {root: true});
        },

        
        
        
        
        
        
    // 유저 정보 수정 처리
    userRegistration(context, form) {
            const url = '/api/registration'
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };


            // form data 세팅
            const formData = new FormData();

            formData.append('account', form.account);
            formData.append('name', form.name);
            formData.append('password', form.password);
            formData.append('passwordChk', form.passwordChk);
            formData.append('nickname', form.nickname);
            formData.append('phone_number', form.phone_number);
            formData.append('address', form.address);
            formData.append('detail_address', form.detail_address);
            formData.append('post_code', form.zonecode);
            formData.append('gender', form.gender);
            formData.append('file', form.file);

            console.log(form.file);
            console.log(form.detail_address);

            axios.post(url, formData, config)
            .then(response => {
                alert('회원 가입이 완료되었습니다.');

                router.replace('/login');
            })
            .catch(error => {
                console.error(error.response.data); // 오류 메시지 확인
                let errorMsgList = [];
                const errorData = error.response.data;
                if(error.response.status === 422) {
                    if(errorData.data.account) {
                        errorMsgList.push('아이디 중복 체크를 확인해주세요.');
                    }
                    if(errorData.data.password_chk) {
                        errorMsgList.push('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
                    }
                    if(errorData.data.name) {
                        errorMsgList.push('성함은 2~4글자의 한글만 입력 가능합니다.');
                    }
                    if(errorData.data.nickname) {
                        errorMsgList.push('닉네임은 영어, 숫자, 한글만 가능하며 최대 8자리까지 입력 가능합니다.');
                    }
                    if(errorData.data.detail_address) {
                        errorMsgList.push('상세주소는 한글과 숫자만 가능하며 최대 20자리까지 입력 가능합니다.');
                    }
                    if(errorData.data.phone_number) {
                        errorMsgList.push('전화번호는 010-0000-0000 형식으로 입력해야 합니다.');
                    }
                    if(errorData.data.gender) {
                        errorMsgList.push('성별을 선택해주세요.');
                    }
                    if(errorData.data.address) {
                        errorMsgList.push('주소를 설정해주세요.');
                    }
                }else{
                    alert('알 수 없는 에러입니다.')
                }

                alert(errorMsgList.join('\n'));
            });
    },
       
       
       
       
       
       /**
        * 토큰 만료 체크 후 처리 속행
        * 
        * @param {*} context
        * @param {function} callbackProccess
        * 
        */
       chkTokenAndContinueProcess(context,  callbackProcess) {
           // Payload 획득
           const payLoad = localStorage.getItem('accessToken').split('.')[1];
           const base64 = payLoad.replace(/-/g, '+').replace(/_/g, '/');
           // parse : 해당 요소를 디코드 해주는 메소드
           const objPayload = JSON.parse(window.atob(base64));

           const now = new Date();
           const nowTotal = Math.floor(now.getTime() / 1000);

           // console.log(nowTotal, objPayload.exp);

           if(objPayload.exp > nowTotal) {
               // console.log('토큰 유효');
               callbackProcess();
           }else {
               // console.log('토큰 만료');
               context.dispatch('reissueAccessToken', callbackProcess);
           }
       },

       
       


       /** 토큰 재발급 처리
        * @param {*} context
        * @param {callback} callbackProcess 
        */
       reissueAccessToken(context, callbackProcess) {
           // console.log('토큰 재발급 처리');
           const url = '/api/reissue'
           const config = {
               headers: {
                   'Authorization' : 'Bearer ' + localStorage.getItem('refreshToken')
               }
           };

           axios.post(url, null, config)
           .then(response => {
               // 토큰 세팅
               localStorage.setItem('accessToken', response.data.accessToken);
               localStorage.setItem('refreshToken', response.data.refreshToken);

               // 후속 처리 진행
               callbackProcess();
           })
           .catch(error => {
               console.error(error);
           });
       }
        
    }
	,getters: {
		
	}
}