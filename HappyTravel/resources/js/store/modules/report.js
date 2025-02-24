import axios from "axios"

export default {
	namespaced: true,
	state: () => ({
		ReportCommentList : []
	})
	,mutations: {
		setReportCommentList(state, report) {
			state.ReportCommentList = report;
		}
	}
	,actions: {
        reportComment(context, data) {
			context.dispatch('auth/chkTokenAndContinueProcess', () => {
				const url = '/api/reports';
				if(context.state.controllerFlg) {
					context.commit('post/setControllerFlg', false, {root: true});
				}

				const config = {
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
					}
				};
				//  JSON.stringify(data) 로 오류 catch쪽으로감  report_board_id 가 string이 아니기때문인가?
				// 데이터는 변환되는데 서버쪽으로 데이터가 전달이 안되서 빈값이 나오는거였음..
				// const param = JSON.stringify(data);
				// console.log(data, param);

				// // 신고 쿠키확인
				// function getCookie(name) {
				// 	const cookies = document.cookie.split(';');
				// 	for(let i = 0; i < cookies.length; i++) {
				// 		let cookie = cookies[i].trim();
				// 		if(cookie.startsWith(name + '=')) {
				// 			return cookie.substring(name.length + 1);
				// 		}
				// 	}
				// 	return null;
				// }
				// const username = getCookie('reports013');
				// console.log(username);
				
				axios.post(url, data, config)
				.then(response => {
					console.log(response.data);
					// if(response.data.success == false) {
					// 	throw new Error("신고 예외 발생시킴");
					// }
					alert('신고접수가 완료되었습니다.');
				})
				.catch(error => {
					// error.response로 원인 체크
					console.log(error.response);
					if(error.response.status === 422) {
						alert('이미 신고처리 되었습니다.');
					};					
				})
				.finally(() => {
					context.commit('post/setControllerFlg', true, {root: true});
				});
			}, {root: true});
		}
	}
	,getters: {

	}
}	