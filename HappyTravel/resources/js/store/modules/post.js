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
const controller = new AbortController();

export default {
	namespaced: true,
	state: () =>({
		// post 부분

		comment : {picture: '/img/abc.png', comment : '랄ㄹ랄ㄹ', name: '펫타곤', created_at: '2024-12-10'}
		,postList : []
		,postDetail : {}
		,currentPage : 0
		,totalPage : 0
		,isLoading : false
		,isSearching : false
		,beforeSearch : ''
		,beforeLocal : '00'

		// index 부분
		,viewList : []
		,likeList : []
	})
	,mutations: {
		// post 부분

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

		,setPostDetail(state, data){
			state.postDetail = data;
		}

		,setIsSearching(state, flg){
			state.isSearching = flg;
		}
		
		,setBeforeSearch(state, comment){
			state.beforeSearch = comment;
		}
		,setBeforeLocal(state, comment){
			// default : '00'
			state.beforeLocal = comment;
		}

		// post 전체 초기화
		,setInitialize(state){
			state.postList = [];
			state.currentPage = 0;
			state.totalPage = 0;
			state.isSearching = false;
			state.beforeSearch = '';
			state.beforeLocal = '00';
			state.isLoading = false;
		}

		// index 부분
		,setViewList(state, lists){
			state.viewList = lists;
		}
		,setLikeList(state, lists){
			state.likeList = lists;
		}

		// post 전체 초기화
		,setInitialize(state){
			state.postList = [];
			state.currentPage = 0;
			state.totalPage = 0;
			state.isSearching = false;
			state.beforeSearch = '';
			state.beforeLocal = '00';
			state.isLoading = false;
		}

		// index 부분
		,setViewList(state, lists){
			state.viewList = lists;
		}
		,setLikeList(state, lists){
			state.likeList = lists;
		}
	}
	,actions: {
		// 포스트 찾기
		index(context, payload){
			if(context.state.totalPage !==0 && context.state.currentPage >= context.state.totalPage){
				return ;
			}

			if(payload === true){
				context.commit('setInitialize');
			}

			if(context.state.beforeSearch === '' && context.state.beforeLocal === '00'){
				context.commit('setIsLoading', true);
				
								
				const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}`;
				axios.get(url)
				.then( response => {
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
				context.commit('setInitialize');
			}
			
			context.commit('setIsLoading', true);

			const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}&search=${payload}`;
			axios.get(url)
			.then( response => {
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
		// 포스트 지역 찾기
		,localSearch(context, payload){			
			if(context.state.beforeLocal === '00' || context.state.beforeLocal !== payload){
				context.commit('setInitialize');
			}

			context.commit('setIsLoading', true);

			const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}&local=${payload}`;
			axios.get(url)
			.then( response => {
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
		// index 페이지에 필요한 애들 가져오기
		,indexes(context, payload){
			const url ='http://127.0.0.1:8000/api/posts/type';
			const urlView = 'http://127.0.0.1:8000/api/posts/type?type=view';
			const urlLike = 'http://127.0.0.1:8000/api/posts/type?type=like';

			
			if(payload === true){
				controller.abort();
			}

			else{
				// 조회수 순 데이터 가져오기
				axios.get(urlView)
				.then(response => {
					context.commit('setViewList',response.data.PostList.data);
				}).catch(error => {
					console.log(error);
				});

				// 좋아요 순 데이터 가져오기
				axios.get(urlLike)
				.then(response => {
					context.commit('setLikeList',response.data.PostList.data);
				}).catch( error => {
					console.log(error);
				});

				// 최신 데이터 가져오기
				axios.get(url, { signal: controller.signal })
				.then(response => {
					context.commit('setPostList',response.data.PostList.data);
				}).catch(error => {
					console.log(error);
				});
			}
			
		}
		// 포스트 상세 출력
		,showPost(context, id){
			const url = '/api/post/detail/' + id;
			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}
			axios.get(url, config)
			.then(response => {
				context.commit('post/setPostDetail', response.data.post, {root: true});
			})
			.catch(error => {
				console.log(error);
			});
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