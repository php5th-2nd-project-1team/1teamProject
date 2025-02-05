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
				const url = '/api/reports/';
				if(context.state.controllerFlg) {
					context.commit('post/setControllerFlg', false, {root: true});
				}

				const config = {
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
					}
				};
				//  JSON.stringify(data) 로 오류 catch쪽으로감  report_board_id 가 string이 아니기때문인가?
				// const param = JSON.stringify(data);

				axios.post(url, data, config)
				.then(response => {
					alert('신고접수가 완료되었습니다.');
				})
				.catch(error => {
					// error.response로 원인 체크
					console.log(error.response);					
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