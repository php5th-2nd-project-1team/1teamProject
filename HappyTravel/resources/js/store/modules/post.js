import axios from "axios";

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
			state.postComment.unshift(comment);
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
			state.postComment = '';
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
				// TODO 00번일 때 context.dispatch('index'); 실행시키고 return 시키기
				if(payload === '00'){
					console.log(payload);
					context.dispatch('index');
					return;
				}
			}
			

			context.commit('setIsLoading', true);

			const url = `http://127.0.0.1:8000/api/posts?page=${context.getters['getNextPage']}&local=${payload}`;
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
				context.commit('setBeforeLocal', payload);
			});
		}
		// index 페이지에 필요한 애들 가져오기
		,indexes(context, payload){
			const url ='http://127.0.0.1:8000/api/posts/type';
			const urlView = 'http://127.0.0.1:8000/api/posts/type?type=view';
			const urlLike = 'http://127.0.0.1:8000/api/posts/type?type=like';

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

				context.commit('setCurrentPage', response.data.PostComment.current_page);
				if(context.state.totalPage === 0) {
					context.commit('setTotalPage', response.data.PostComment.last_page);
				}
				// console.log(response.data.PostComment);
			})
			.catch(error => {
				console.error(error);
			}).finally(() => {
				context.commit('setIsLoading', false);
			});
		}

		// ---------------댓글 작성 진짜 모르겠다.---------------------------------

		// 포스트 댓글 작성(하는중)
		,storePostComment(context, data) {
			// console.log('data:', data);
			const url = '/api/posts/' + data.post_id;

			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}
			// // form data 생성
			// const formData = new formData();
			// // 전달 데이터 셋팅
			// formData.append('post_comment', data.post_comment);
			// const serialize = new serialize();
			const commentData = {
				post_comment: data.post_comment,
				post_id: data.post_id,
			};
			// json으로 파싱
			const Data = JSON.stringify(commentData);

			// axios
			axios.post(url, Data, config)
			.then(response => {
				context.commit('setPostCommentListUnshift', response.data.postComment);	// response.data.??? 이뒤에 포스트댓글 어디로 오는지 체크
				// console.log(response.data.postComment);
				// alert('댓글을 작성하였습니다.');
			})
			.catch(error => {
				console.error('댓글 작성 실패');
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