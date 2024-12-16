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

                if(error.response.status === 422) {
                    console.log(error.response.data.errors); // 각 필드의 에러 메시지 출력
                    // 유효성 체크 에러
                    if(errorData.data.account) {
                        alert(errorMsgList.push(errorData.data.account[0]));
                    }
                    if(errorData.data.password) {
                        alert(errorMsgList.push(errorData.data.password[0]));
                    }else if(error.response.status === 401) {
                        // 비밀번호 오류 에러
                        alert(errorMsgList.push('비밀번호 오류'));
                    }else {
                        errorMsgList.push('잘 모르겠는 오류');
                    }

                    alert(errorMsgList.join('\n'));
                    
                    
                }
            });
        },

        
         /**
        * 로그아웃 처리
        * @param {*} context
        */
        logout(context)  {
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

        },
        
        
        
        
        
    //     /**
    //     * 회원가입 처리
    //     * 
    //     * @param {*} context
    //     * @param {*} userInfo
    //     */
    //    registration(context, userInfo) {
    //        const url = '/api/registration'
    //        const config = {
    //            headers: {
    //                'Content-Type': 'mutipart/form-data'
    //            }
    //        };
           
    //        // form data 세팅
    //        const formData = new FormData();
    //        formData.append('account', userInfo.account);
    //        formData.append('password', userInfo.password);
    //        formData.append('password_chk', userInfo.password_chk);
    //        formData.append('name', userInfo.name);
    //        formData.append('gender', userInfo.gender);
    //        formData.append('profile', userInfo.profile);

    //        axios.post(url, formData, config)
    //        .then(response => {
    //            alert('성공함');
    //            router.replace('/login');
    //        })
    //        .catch(error => {
    //            alert('실패함');
    //        });
           

    //    },
       
       
       
       
       
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