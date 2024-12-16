import axios from "axios";
import { useStore } from "vuex";

// const store = useStore();

// function resetAllPost(){
// 	store.commit('resetPostList');
// 	store.commit('setIsLoading', false);
// 	store.commit('setCurrentPage', 0);
// 	store.commit('setTotalPage', 0);
// 	store.commit('setIsSearching', false);
// 	store.commit('setBeforeSearch', '');
// 	store.commit('setBeforeLocal', '00');
// }

export default {
	namespaced: true,
	state: () =>({
		comment : {picture: '/img/abc.png', comment : '랄ㄹ랄ㄹ', name: '펫타곤', created_at: '2024-12-10'}
		,postList : []
		,postDetail : {}
		,currentPage : 0
		,totalPage : 0
		,isLoading : false
		,isSearching : false
		,beforeSearch : ''
		,beforeLocal : '00'
	})
	,mutations: {
		setPostList(state, lists){
			state.postList = state.postList.concat(lists);
		}
		,resetPostList(state){
			state.postList = [];
		}

		,setIsLoading(state, flg){
			state.isLoading = flg;
		}

		,setCurrentPage(state, page){
			state.currentPage = page;
		}

		,setTotalPage(state, page){
			state.totalPage = page;
		}

		,setDetail(state, data){
			state.postDetail = data;
		}

		,setIsSearching(state, flg){
			state.isSearching = flg;
		}
		
		,setBeforeSearch(state, comment){
			state.beforeSearch = comment;
		}
		,setBeforeLocal(state, comment){
			state.beforeLocal = comment;
		}
	}
	,actions: {
		// 포스트 찾기
		index(context, payload){
			if(context.state.totalPage !==0 && context.state.currentPage >= context.state.totalPage){
				return ;
			}

			if(context.state.beforeSearch === '' && context.state.beforeLocal === '00'){
				context.commit('setIsLoading', true);

				const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}`;
				axios.get(url)
				.then( response => {
					console.log(response.data.PostList);
					context.commit('setPostList', response.data.PostList.data);
					context.commit('setCurrentPage', response.data.PostList.current_page);					
					if(context.state.totalPage === 0){
						context.commit('setTotalPage', response.data.PostList.last_page);
					}
				}).catch (error => {
					console.log(error);
				}).finally(() => {
					context.commit('setIsLoading', false);
				});
			} else if( context.state.beforeSearch !== '' ) {
				context.dispatch('search', context.state.beforeSearch);
			} else {
				context.dispatch('localSearch', context.state.beforeLocal);
			}
		}
		// 포스트 검색 찾기
		,search(context, payload){
			
			if(context.state.beforeSearch !== payload){
				context.commit('resetPostList');
				context.commit('setIsLoading', false);
				context.commit('setCurrentPage', 0);
				context.commit('setTotalPage', 0);
				context.commit('setIsSearching', false);
				context.commit('setBeforeSearch', '');
				context.commit('setBeforeLocal', '00');
			}
			
			context.commit('setIsLoading', true);

			const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}&search=${payload}`;
			axios.get(url)
			.then( response => {
				console.log(response.data.PostList);
				context.commit('setPostList', response.data.PostList.data);
				context.commit('setCurrentPage', response.data.PostList.current_page);
				context.commit('setBeforeSearch', payload);
				if(context.state.totalPage === 0){
					context.commit('setTotalPage', response.data.PostList.last_page);
				}
			}).catch (error => {
				console.log(error);
			}).finally(() => {
				context.commit('setIsLoading', false);
				context.commit('setIsSearching', true);
			});
		}
		,localSearch(context, payload){			
			if(context.state.beforeLocal === '00' || context.state.beforeLocal !== payload){
				context.commit('resetPostList');
				context.commit('setIsLoading', false);
				context.commit('setCurrentPage', 0);
				context.commit('setTotalPage', 0);
				context.commit('setIsSearching', false);
				context.commit('setBeforeSearch', '');
				context.commit('setBeforeLocal', '00');
			}

			context.commit('setIsLoading', true);

			const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}&local=${payload}`;
			axios.get(url)
			.then( response => {
				console.log(response.data.PostList);
				context.commit('setPostList', response.data.PostList.data);
				context.commit('setCurrentPage', response.data.PostList.current_page);
				context.commit('setBeforeSearch', payload);
				if(context.state.totalPage === 0){
					context.commit('setTotalPage', response.data.PostList.last_page);
				}
			}).catch (error => {
				console.log(error);
			}).finally(() => {
				context.commit('setIsLoading', false);
				context.commit('setBeforeLocal', payload);
			});
		}
		,detail(context, payload){

		}
	}
	,getters: {
		getNextPage(state){
			return state.currentPage + 1;
		}
		,getIsLastPage(state){
			return state.currentPage >= state.totalPage;
		}
	}
}