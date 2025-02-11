import axios from '../../axios';
import router from '../../router';


export default {
	namespaced: true,
	state: () => ({
		isLoading : false, // 로딩 여부
		inquiryList: [], // 문의 게시글 목록
		currentPage : 1, // 현재 페이지
		totalPage : 0, // 총 페이지 수
		label : [], // 페이지 번호
	})
	,mutations: {
		// 로딩 여부 설정
		setIsLoading(state, payload) {
			state.isLoading = payload;
		},

		// 문의 게시글 설정
		setInquiryList(state, payload) {
			state.inquiryList = payload;
		},

		// 현재 페이지 설정
		setCurrentPage(state, payload) {
			state.currentPage = payload;
		},

		// 총 페이지 수 설정
		setTotalPage(state, payload) {
			state.totalPage = payload;
		},

		// 페이지 번호 설정
		setLabel(state, payload) {
			state.label = payload;
		}
	}
	,actions: {
		// 문의 게시글 목록 가져오기
		getInquiryList(context, page) {
			// 만약 마지막 페이지 이상이면 문의 메인 페이지로 이동
			if(context.state.currentPage > context.state.totalPage && context.state.totalPage !== 0) {
				router.push('/inquiry');
				return;
			}

			// 만약 첫 페이지 이하면 문의 메인 페이지로 이동
			if(context.state.currentPage < 1) {
				router.push('/inquiry');
				return;
			}

			// 만약 로딩 중이면 리턴
			if(context.state.isLoading){
				return;
			}

			// 로딩 중 표시
			context.commit('setIsLoading', true);
			const url = '/api/inquiry?page=' + page;	

			// 문의 게시글 목록 가져오기
			axios.get(url)
			.then(response => {
				context.commit('setInquiryList', response.data.data.data);
				context.commit('setTotalPage', response.data.data.last_page);
				context.commit('setCurrentPage', response.data.data.current_page);
				context.commit('setLabel', response.data.data.links);
				console.log(response.data);
			}).catch(error => {
				console.error(error);
			}).finally(() => {
				// 로딩 중 표시 해제
				context.commit('setIsLoading', false);
			});
		}
	}
	,getters: {

	}
}	