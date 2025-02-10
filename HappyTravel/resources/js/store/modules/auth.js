import axios from '../../axios';
import router from '../../router';
import { createStore } from "vuex";

export default {
	namespaced: true,
	state: () =>({
		// 로컬 스토리지에 accessToken이 있으면 true, 그렇지 않으면 false
		authFlg: localStorage.getItem('accessToken') ? true : false,
		
		// 로컬 스토리지에 userInfo가 있으면 그대로 저장, 혹은 빈 객체
		userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : {}, 

		userIdChkFlg: false,

		userEmailChkFlg: false, 

		userVerificationCodeFlg: false,

		loadingFlg: false,

		tokenValid: false,

		accountMessage: '',

		findingAccount : '',
	}),
	mutations: {
		setAuthFlg(state, flg) {

			state.authFlg = flg;
		},
		
		setUserInfo(state, userInfo) {
			state.userInfo = userInfo;
		},
		
		setUserIdChkFlg(state, flg) {
			state.userIdChkFlg = flg;
		},
		setUserEmailChkFlg(state, flg) {
			state.userEmailChkFlg = flg;
		},
		setUserVerificationCodeFlg(state, flg) {
			state.userVerificationCodeFlg = flg;
		},
		setLoadingFlg(state, flg) {
			state.loadingFlg = flg;
		},
		setResetMessage(state, message) {
			state.resetMessage = message;
		},
		setTokenValid(state, isValid) {
			state.tokenValid = isValid;
		},
		setAccountMessage(state, message) {
			state.accountMessage = message;
		},
		setFindingAccount(state, account) {
			state.findingAccount = account;
		}
	},   
	actions: {
		login(context, userInfo) {


			const url = '/api/login';
			const data = JSON.stringify(userInfo);

			axios.post(url, data)
				.then(response => {
					localStorage.setItem('accessToken', response.data.accessToken);
					localStorage.setItem('userInfo', JSON.stringify(response.data.data));
					context.commit('setAuthFlg', true);
					context.commit('setUserInfo', response.data.data);

					router.replace('/');
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
					if(error.response.status !== 402) {
						alert(errorMsgList.join('\n'));
					}
				});
		},

		socialLogin(context, provider) {  
			const url = `/api/auth/${provider}`;
		
			axios.get(url)
				.then(response => {
					const redirectUrl = response.data.redirect_url;
					// 소셜 로그인 URL로 리다이렉트
					window.location.href = redirectUrl;
				})
				.catch(error => {
					console.error(error.response.data); // 에러 메시지 로깅
					alert('소셜 로그인 요청에 실패했습니다. 다시 시도해주세요.');
				});
		},

		socialLoginInfo(context) {
			const url = `/api/auth/social/Info`;
			axios.post(url)
				.then(response => {
					localStorage.setItem('accessToken', response.data.accessToken);
					localStorage.setItem('userInfo', JSON.stringify(response.data.data));
					context.commit('setAuthFlg', true);
					context.commit(' ', response.data.data);
					router.replace('/');
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
					if(error.response.status !== 402) {
						alert(errorMsgList.join('\n'));
					}
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

		// 아이디 중복 체크 
		userIdCheck(context, userId) {
			const url = '/api/userIdCheck';
			const data = JSON.stringify(userId);

			// console.log(userId);

			axios.post(url, data)
				.then(response => {
					context.commit('setUserIdChkFlg', true);
					alert('사용 가능한 아이디입니다.');
				})
				.catch(error => {
					context.commit('setUserIdChkFlg', false);

					let errorMsgList = [];
					const errorData = error.response.data;

					if(error.response.status === 422) {
						// console.log(errorData.data.account)
						if(errorData.data.account) {
							errorMsgList.push('아이디는 6자 이상 20자 이하의 영문 혹은 영문과 숫자를 조합해주세요.');
						}
						alert(errorMsgList.join('\n'));
					}else if(error.response.status === 402) {
						alert('이미 사용중인 아이디입니다.');
					}
				});
		},

		// 유저 회원가입 처리
		userRegistration(context, form) {
			if(!context.state.userIdChkFlg) {
				alert('아이디 중복 체크를 확인해주세요.');
			}else if(!context.state.userEmailChkFlg) {
				alert('이메일 인증을 완료해주세요.');
			}
			else{
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
				formData.append('email', form.email);
				formData.append('file', form.file);
		
				// console.log(form.file);
				// console.log(form.detail_address);
				// 이상 무
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
							errorMsgList.push('회원가입 정보를 다시 확인해주세요.');
						}else{
							alert('알 수 없는 에러입니다.')
						}
		
						alert(errorMsgList.join('\n'));
					});
			}
		},

		userEmailChk(context, userEmail) {
			return new Promise((resolve, reject) => {
				const url = '/api/send-verification-code';
		
				const data = JSON.stringify(userEmail);
		
				axios.post(url, data)
					.then(response => {
						alert(response.data.message);
						return resolve();
					})
					.catch(error => {
						console.error(error.response); // 오류 메시지 확인
						alert('이미 사용중인 이메일입니다,');
						return reject();
					});
			});
		},

		userVerificationCode(context, verificationCode) {
			const url = '/api/verify-code';
			const data = JSON.stringify(verificationCode);

			axios.post(url, data)
				.then(response => {
					context.commit('setUserEmailChkFlg', true);
					context.commit('setUserVerificationCodeFlg', true);
					alert(response.data.message);
				})
				.catch(error => {
					console.error(error.response); // 오류 메시지 확인
					alert(error.response.data.message);
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

		/** 
		 * 토큰 재발급 처리
		 * @param {*} context
		 * @param {callback} callbackProcess 
		 */
		reissueAccessToken(context, callbackProcess) {
			// console.log('토큰 재발급 처리');
			const url = '/api/reissue'

			axios.post(url)
				.then(response => {
					// 토큰 세팅
					localStorage.setItem('accessToken', response.data.accessToken);

					// 후속 처리 진행
					callbackProcess();
				})
				.catch(error => {
					console.error(error);
					context.commit('user/setLoadingFlg', false, {root: true});
					if(error.response.status === 403) {
						localStorage.clear();
						// Auth 플레그 했던 거 지우기
						context.commit('setAuthFlg', false);
						context.commit('setUserInfo', {});
						alert('로그인 시간이 만료되었습니다.');
						router.replace('/login');
					}else {
						alert('알 수 없는 오류');
					}
				});
		},

		// 비밀번호 찾기 이메일 보냄
		requestPasswordReset(context, passwordReset ) {
			context.commit('setLoadingFlg', true);

			const url = '/api/password-reset/request';

			const formData = new FormData();
		
			formData.append('email', passwordReset.email);
			formData.append('name', passwordReset.name);

			return axios.post(url, formData)
				.then(response => {
					context.commit('setResetMessage', '비밀번호 변경 이메일이 발송되었습니다.');
					context.commit('setLoadingFlg', false);
				})
				.catch(error => {
					console.error(error.response.data); // 오류 메시지 확인
					let errorMsg = error.response?.data?.message || "이메일을 확인하세요.";
					context.commit('setResetMessage', errorMsg);
				});
		},

		// 비밀번호 찾기 이메일 인증 확인
		verifyResetToken(context, payload) {
			context.commit('setLoadingFlg', true);

			const url = `/api/password-reset/verify?token=${payload.token}&email=${payload.email}`;

			return axios.get(url)
				.then(response => {
					context.commit('setTokenValid', true);
					context.commit('setLoadingFlg', false);
				})
				.catch(error => {
					console.error(error.response.data);
					context.commit('setTokenValid', false);
					
					alert(error.response.data.message);
					route.push('/login');
				});
		},

		// 비밀번호 수정
		resetPassword(context, payload) {
			const url = "/api/password-reset/reset";

			return axios.post(url, payload)
				.then(response => {
					context.commit('setResetMessage', "비밀번호가 변경되었습니다.");
					context.commit('setTokenValid', false);
					router.push("/login");
				})
				.catch(error => {
					console.error(error.response.data);
					let errorMsg = error.response?.data?.message || "비밀번호 변경에 실패했습니다.";
					context.commit('setResetMessage', errorMsg);
				});
		},

		// 아이디 찾기 이메일 전송
		requestAccountEmail(context, payload) {
			context.commit('setLoadingFlg', true);

			const url = '/api/account-email/request';

			return axios.post(url, payload)
				.then(response => {
					context.commit('setAccountMessage', '아이디 확인 이메일이 발송되었습니다.');
					context.commit('setLoadingFlg', false);
				})
				.catch(error => {
					console.error(error.response.data); // 오류 메시지 확인
					let errorMsg = error.response?.data?.message || "이메일을 확인하세요.";
					context.commit('setAccountMessage', errorMsg);
				});
		},

		// 아이디 찾기 이메일 확인
		checkAccountEmail(context, payload) {
			context.commit('setLoadingFlg', true);

			const url = `/api/account-email/request?token=${payload.token}&email=${payload.email}`;

			axios.get(url)
				.then(response => {
					context.commit('setFindingAccount', response.data.data.account);
					context.commit('setTokenValid', true);
					context.commit('setLoadingFlg', false);
				})
				.catch(error => {
					console.error(error.response); // 오류 메시지 확인
					context.commit('setTokenValid', false);
					if(error.response.data.message === '토큰이 만료되었습니다'){
						alert('늦은 접근입니다. 다시 시도해 주십시오');
					} else if(error.response.data.message === '유효하지 않은 토큰입니다.'){
						alert('유효하지 않은 접근입니다.');
					} else {
						alert('잠시 후 다시 시도해주세요.');
					}
					router.push('/login');
				});

		}
	},
	getters: {
		
	}
}
