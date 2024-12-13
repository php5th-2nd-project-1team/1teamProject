import axios from '../../axios';
import router from '../../router';

export default {
	namespaced: true,
	state: () => ({
        // 로컬 스토리지에 accessToken이 있으면 true, 그렇지 않으면 false
        authFlg: localStorage.getItem('accessToken') ? true : false,
        
        // 로컬 스토리지에 userInfo가 있으면 그대로 저장, 혹은 빈 객체
        userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : {}, 

        allUserInfo: {},
        loadingFlg: false,
	})
	,mutations: {
        setAuthFlg(state, flg) {
            state.authFlg = flg;
        },
        
        setUserInfo(state, userInfo) {
            state.userInfo = userInfo;
        },
        setAllUserInfo(state, allUserInfo) {
            state.allUserInfo = allUserInfo;
        },
        setLoadingFlg(state, loadingFlg) {
            state.loadingFlg = loadingFlg;
        }

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

                router.replace('/boards');
            })
            .catch(error => {
                console.error(error.response.data); // 오류 메시지 확인
                let errorMsgList = [];
                const errorData = error.response.data;

                if(error.response.status === 422) {
                    console.log(error.response.data.errors); // 각 필드의 에러 메시지 출력
                    // 유효성 체크 에러
                    if(errorData.data.account) {
                        errorMsgList.push(errorData.data.account[0]);
                    }
                    if(errorData.data.password) {
                        errorMsgList.push(errorData.data.password[0]);
                    }else if(error.response.status === 401) {
                        // 비밀번호 오류 에러
                        errorMsgList.push('비밀번호 오류');
                    }else {
                        errorMsgList.push('잘 모르겠는 오류');
                    }

                    alert(errorMsgList.join('\n'));
                    
                    
                }
            });
        },

        userDetailPage(context, id) {
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
            
        }
    }
	,getters: {
		
	}
}