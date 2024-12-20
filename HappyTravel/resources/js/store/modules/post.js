import axios from "../../axios";

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
let controller = null;

export default {
	namespaced: true,
	state: () =>({
		// post 부분
		postCommentList : []
		,postComment : ''
		,postList : []
		,postDetail : {post_lat : 37.34083789, post_lon : 126.882195}
		,currentPage : 0
		,totalPage : 0
		,isLoading : false
		,isSearching : false
		,beforeSearch : ''
		,beforeLocal : '00'
		,controllerFlg : false
		,lastPageFlg : false
		,postCommentCnt : 0
		
		// index 부분
		,postIndexList :[]
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

		,setPostDetail(state, post){
			state.postDetail = post;
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
		// 포스트 댓글 리스트
		,setPostCommentList(state, lists) {
			state.postCommentList = state.postCommentList.concat(lists);
		}
		// 포스트 댓글 작성 최상위로 이동
		,setPostCommentListUnshift(state, comment) {
			state.postCommentList.unshift(comment);
		}
		// 포스트 댓글 페이지네이션 컨트롤
		,setControllerFlg(state, flg) {
			state.controllerFlg = flg;
		}
		// 포스트 댓글 페이지네이션 컨트롤
		,setLastPageFlg(state, flg) {
			state.lastPageFlg = flg;
		}
		// // 포스트 댓글 갯수
		,setpostCommentCnt(state, count) {
			state.postCommentCnt = count;
		}

		// post 전체 초기화
		,setInitialize(state){
			state.postList = [];
			state.currentPage = 0;
			state.totalPage = 0;
			state.isSearching = false;
			state.beforeSearch = '';
			state.beforeLocal = '';
			state.isLoading = false;
			state.postComment = '';
			state.postCommentList = [];
			state.postCommentCnt = 0;
		}

		// index 부분
		,setPostIndexList(state, lists){
			state.postIndexList = lists
		}
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

			if(context.state.beforeLocal !== ''){
				if(context.state.beforeSearch !== ''){
					context.dispatch('search', context.state.beforeSearch);
				}
				else{
					context.dispatch('localSearch', context.state.beforeLocal);
				}
			} else {
				context.commit('setIsLoading', true);

				const url = `/api/posts?page=${context.getters['getNextPage']}`;
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
			}
		}
		// 포스트 검색 찾기
		,search(context, payload){
			if(context.state.beforeSearch !== payload){
				const beforeLocal = context.state.beforeLocal;
				context.commit('setInitialize');
				context.commit('setBeforeLocal', beforeLocal);
				console.log(context.state.beforeLocal);
			}
			
			context.commit('setIsLoading', true);

			const url = `/api/posts?page=${context.getters['getNextPage']}&search=${payload}&local=${context.state.beforeLocal}`;
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
			if(context.state.beforeLocal === '' || context.state.beforeLocal !== payload){
				context.commit('setInitialize');
				if(payload === ''){
					context.dispatch('index');
					return;
				}
			}
			

			context.commit('setIsLoading', true);

			const url = `/api/posts?page=${context.getters['getNextPage']}&local=${payload}`;
			axios.get(url)
			.then( response => {
				context.commit('setPostList', response.data.PostList.data);
				context.commit('setCurrentPage', response.data.PostList.current_page);
				context.commit('setBeforeLocal', payload);
				if(context.state.totalPage === 0){
					context.commit('setTotalPage', response.data.PostList.last_page);
				}
			}).catch (error => {
				console.log(error);
			}).finally(() => {
				context.commit('setIsLoading', false);
			});
		}
		// index 페이지에 필요한 애들 가져오기
		,indexes(context, payload){
			const url ='/api/posts/type';
			const urlView = '/api/posts/type?type=view';
			const urlLike = '/api/posts/type?type=like';

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
			axios.get(url)
			.then(response => {
				context.commit('setPostIndexList',response.data.PostList.data);
			}).catch(error => {
				console.log(error);
			});	
		}

		// 포스트 상세 출력
		,showPost(context, id){
			const url = '/api/posts/' + id;
			
			
			context.commit('setIsLoading', true);
			
			axios.get(url)
			.then(response => {
				// context.commit('post/setPostDetail', response.data.post, {root: true});
				context.commit('setPostDetail', response.data.PostDetail);	// data안에 PostDetail 안에 원하는 데이터가 있음
				context.commit('setPostCommentList', response.data.PostComment.data);
				context.commit('setpostCommentCnt', response.data.postCommentCnt);

				context.commit('setCurrentPage', response.data.PostComment.current_page);
				if(context.state.totalPage === 0) {
					context.commit('setTotalPage', response.data.PostComment.last_page);
				}
				// console.log(response.data.PostComment.data);
			})
			.catch(error => {
				console.error(error);
			}).finally(() => {
				context.commit('setIsLoading', false);
			});
		}

		// 포스트 댓글 작성(하는중)
		,storePostComment(context, data) {
			const url = '/api/posts/' + data.post_id;
			// const url = `/api/posts/${data.post_id}`;

			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}

			const useData = {
				post_comment: data.post_comment,
			};
			// json으로 파싱
			const param = JSON.stringify(useData);

			axios.post(url, param, config)
			.then(response => {
				context.commit('setPostCommentListUnshift', response.data.storePostComment);
				alert('댓글을 작성하였습니다.');
				
				// console.log(response.data.postComment);
			})
			.catch(error => {
				// console.error('댓글 작성 실패');
				console.error('댓글 작성 실패:============='); // 서버의 에러 메시지 출력
				console.error(error); // 서버의 에러 메시지 출력
    			alert('댓글 작성에 실패했습니다. 에러 메시지: ' + (error.response?.data?.message || '알 수 없는 오류'));
			});
		}

		// 포스트 댓글 페이지네이션
		,postCommentPagination(context) {
			// if(context.state.controllerFlg && !context.state.lastPageFlg) {
			// 	context.commit('setControllerFlg', false);
			// }
			context.commit('setIsLoading', true);
			const url = '/api/posts/' + data.post_id;
			axios.get(url, config)
			.then(response => {
				context.commit('setPostCommentList', response.data.PostComment.data);
				conte
			})
			.catch(error => {
				console.error(error);
			})
			.finally(() => {
				context.commit('setIsLoading', true);
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