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
		,commentCurrentPage : 1
		,totalPage : 0
		,isLoading : false
		,isSearching : false
		,beforeSearch : ''
		,beforeLocal : '00'
		,controllerFlg : true
		,lastPageFlg : false
		,commentPage : 0
		,postCommentCnt : 0

		// 좋아요 부분
		,isClkedLike : null
		,isLikeLoading : false
		
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

		,setCommentCurrentPage(state, page) {
			state.commentCurrentPage = page;
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
		// // 디바운싱
		,setControllerFlg(state, flg) {
			state.controllerFlg = flg;
		}
		// // 디바운싱
		,setLastPageFlg(state, flg) {
			state.lastPageFlg = flg;
		}
		// 포스트 댓글 페이지네이션
		,setCommentPage(state, page) {
			state.commentPage = page;
		}
		// // 포스트 댓글 갯수
		,setPostCommentCnt(state, count) {
			state.postCommentCnt = count;
		}
		// 댓글갯수 +1
		,addPostCommentCnt(state) {
			state.postCommentCnt.cnt += 1;
		}
		// 댓글 삭제(댓글의 key값을 받아서 삭제)
		,deleteComment(state, key) {
			state.postCommentList.splice(key, 1);  // splice로 ket값받아서 1개 삭제
		}
		// 댓글갯수 -1
		,subPostCommentCnt(state) {
			state.postCommentCnt.cnt -= 1;
		}

		// 좋아요 여부 
		,setIsClkedLike(state, flg){
			state.isClkedLike = flg;

			console.log( '좋아요 무엇 : ' + state.isClkedLike);
		}

		// 좋아요 개수 여부
		,addLikeCnt(state, flg){
			state.postDetail.post_likes_count += flg;
		}

		// 좋아요 로딩 여부
		,isLikeLoading(state, flg){
			state.isLikeLoading = flg;
		}

		// post 전체 초기화
		,setInitialize(state){
			state.postList = [];
			state.currentPage = 0;
			state.commentCurrentPage = 1;
			state.totalPage = 0;
			state.isSearching = false;
			state.beforeSearch = '';
			state.beforeLocal = '';
			state.isLoading = false;
			state.postComment = '';
			state.postCommentList = [];
			state.postCommentCnt = 0;
			state.isClkedLike = false;
			state.isLikeLoading = false;
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
			// 민주님, 좋아요 버튼 추가에 따라 해당 로직을 수정 및 추가했으니, 확인 후 주석을 지우시거나 놔두시면 됩니다.
			
			context.commit('setIsLoading', true);
			
			const url = '/api/posts/' + id;

			// 계정 로그인 확인 여부 (단, 로그인 여부를 확인하기 위함이므로 미들웨어에서 체크 할 필요 없음. 포스트에서 좋아요가 그리 중요한 것도 아니기 때문에. 좋아요 누를 때 중요한거지.)
			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}
			
			axios.get(url, config) // config 추가함
			.then(response => {
				// context.commit('post/setPostDetail', response.data.post, {root: true});
				context.commit('setPostDetail', response.data.PostDetail);	// data안에 PostDetail 안에 원하는 데이터가 있음
				context.commit('setPostCommentList', response.data.PostComment.data);
				context.commit('setIsClkedLike', response.data.PostClkLike);

				// 지금 페이지랑 마지막 페이지가 같으면 setLastPageFlg true로 바꾸고 댓글더보기 버튼 없애기
				if(response.data.PostComment.current_page === response.data.PostComment.last_page) {
					context.commit('setLastPageFlg', true);
				}

				context.commit('setPostCommentCnt', response.data.PostCommentCnt);
				console.log(response.data.PostComment);

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

		// 포스트 댓글 작성
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
				context.commit('addPostCommentCnt');		// 펫브리즈고 댓글갯수 +
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

		// 좋아요 클릭 기능 만들기
		,postClickLike(context, payload){

			if(context.state.isLikeLoading){
				return;
			}

			context.commit('isLikeLoading', true);

			const url = '/api/posts/like/' + payload;
			const data = JSON.stringify({
				post_likes_flg : !context.state.isClkedLike
			});

			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}

			axios.post(url, data, config)
			.then( response => {
				context.commit('setIsClkedLike', response.data.like_flg.post_likes_flg === '1' ? true : false);
				context.commit('addLikeCnt', response.data.like_flg.post_likes_flg === '1' ? 1 : -1);
			}).catch (error => {
				console.log(error.response);
			}).finally(()=>{
				context.commit('isLikeLoading', false);
			});
		}

		// 포스트 댓글 페이지네이션(작업중)
		,postCommentPagination(context, id) {
			// lastPageFlg 가 true일때는 밑에 처리를 하지 않는다.
			if(context.state.lastPageFlg === true){
				return;
			}

			if(context.state.controllerFlg && !context.state.lastPageFlg) {
				context.commit('setControllerFlg', false);
			}
			
			context.commit('setIsLoading', true);
			const url = '/api/posts/' + id + '?page=' + context.getters['getCommentNextPage'];	// 페이지네이션 꼭?page 로 적어야함
			axios.get(url)
			.then(response => {
				// console.log('댓글 추가 요청', response.data.PostComment);
				context.commit('setPostCommentList', response.data.PostComment.data);
				context.commit('setCommentCurrentPage', response.data.PostComment.current_page);
				
				console.log(response.data.PostComment.current_page, context.state.commentCurrentPage);
				if(response.data.PostComment.current_page >= response.data.PostComment.last_page) {
					console.log('마지막 페이지 도달 : ', response.data.PostComment.current_page, response.data.PostComment.last_page)
					context.commit('setLastPageFlg', true);
				}
			})
			.catch(error => {
				console.error(error);
			})
			.finally(() => {
				context.commit('setIsLoading', false);
				context.commit('setControllerFlg', true);
			});
		}

		// 포스트 댓글 삭제
		,postCommentDelete(context, id) {
			if(context.state.controllerFlg && !context.state.lastPageFlg) {
				context.commit('setControllerFlg', false);
			}
			const url = '/api/posts/' + id[0];
			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}

			axios.delete(url, config)
			.then(response => {
				alert('댓글이 삭제되었습니다.');
				context.commit('deleteComment', id[1]);		// 프론트쪽 id배열의 1번을 삭제한다.
				context.commit('subPostCommentCnt');		// 펫브리즈고 댓글갯수 -
			})
			.catch(error => {
				console.error(error);
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

		,getCommentNextPage(state) {
			return state.commentCurrentPage + 1;
		}
	}
}