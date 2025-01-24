import axios from "../../axios";
import router from "../../router";

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

function setErrorRouter(error_response_data, path){
	if(error_response_data === '테마 번호 오류'){
		router.push(path);
	}
}
let controller = null;

export default {
	namespaced: true,
	state: () =>({
		// post 부분
		post_theme_id : 0
		,post_theme_title : '숙소'
		,postCommentList : []
		,postComment : ''
		,postList : []
		,postDetail : {post_lat : 37.34083789, post_lon : 126.882195}
		,currentPage : 0
		,commentCurrentPage : 1
		,totalPage : 0
		,isLoading : false
		,isDetailLoading : false
		,isSearching : false
		,beforeSearch : ''
		,beforeLocal : '00'
		,controllerFlg : true
		,lastPageFlg : false
		,commentPage : 0
		,postCommentCnt : 0
		,postResultCnt : 0

		// 좋아요 부분
		,isClkedLike : null
		,isLikeLoading : false
		
		// index 부분
		,postIndexList :[]
		,viewList : []
		,likeList : []

		// filter
		,animalType : []
		,facilityType : []
		,postAnimal : []
		,postFacility : []
	})
	,mutations: {
		// post 부분

		setPostThemeId(state, id){
			state.post_theme_id = id;
		}
		,setPostThemeTitle(state){
			switch(state.post_theme_id){
				case '01' :
					state.post_theme_title = '숙소';
					break;
				case '02' :
					state.post_theme_title = '식&음료';
					break;
				case '03' :
					state.post_theme_title = '관광지';
					break;
				case '04' :
					state.post_theme_title = '병원';
					break;
			}
		}

		,setPostList(state, lists){
			state.postList = state.postList.concat(lists);
		}
		,resetPostList(state){
			state.postList = [];
		}

		,setIsLoading(state, flg){
			state.isLoading = flg;
		}

		,setDetailIsLoading(state, flg){
			state.isDetailLoading = flg;
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
		,setPostResultCnt(state, cnt){
			state.postResultCnt = cnt;
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
			state.postResultCnt = 0;
			state.animalType = [];
			state.facilityType = [];
			state.postAnimal = [];
			state.postFacility = [];
		}
		// post local 적용 시 초기화
		,setLocalInitialize(state){
			state.postList = [];
			state.isLoading = false;
			state.currentPage = 0;
			state.totalPage = 0;
			state.beforeSearch = '';
			state.postResultCnt = 0;
			state.animalType = [];
			state.facilityType = [];
		}
		// post filter 적용 시 초기화
		,setFilterInitialize(state){
			state.postList = [];
			state.isLoading = false;
			state.currentPage = 0;
			state.totalPage = 0;
			state.beforeSearch = '';
			state.postResultCnt = 0;
		}
		// post keyword 적용 시 초기화
		,setKeywordInitialize(state){
			state.postList = [];
			state.isLoading = false;
			state.currentPage = 0;
			state.totalPage = 0;
			state.postResultCnt = 0;
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
		// 포스트 필터
		,setAnimalType(state, animalType) {
			state.animalType = animalType;
		}
		,setFacilityType(state, facilityType) {
			state.facilityType = facilityType;
		}
		// 포스트상세 필터출력
		,setAnimalFilter(state, filter) {
			state.postAnimal = filter;
		}
		,setFacilityFilter(state, filter) {
			state.postFacility = filter;
		}

	}
	,actions: {
		index(context, payload){
			// 초기화 타입에 따라 다른 초기화 실행
			switch(payload){
				case 'local': // 지역 검색 초기화
					context.commit('setLocalInitialize');
					break;
				case 'filter': // 필터 검색 초기화
					context.commit('setFilterInitialize');
					break;
				case 'keyword': // 키워드 검색 초기화
					context.commit('setKeywordInitialize');
					break;
				default:
					break;
			}

			// 현재 페이지가 총 페이지 수를 초과하면 중단
			if(context.state.totalPage !==0 && context.state.currentPage >= context.state.totalPage){
				return ;
			}

			// 이미 로딩 중이면 중단
			if(context.state.isLoading){
				console.log('로딩중입니다.');
				return;
			}

			// 로딩 상태 활성화
			context.commit('setIsLoading', true);

			// 기본 URL 생성 (페이지 번호와 테마 ID 포함)
			let url = `/api/posts?page=${context.getters['getNextPage']}&theme=${context.state.post_theme_id}`;

			// 지역 검색 파라미터 추가
			if(context.state.localSearch !== ''){
				url += `&local=${context.state.beforeLocal}`;
			}

			// 검색어 파라미터 추가
			if(context.state.beforeSearch !== ''){
				url += `&search=${context.state.beforeSearch}`;
			}

			// 동물 타입 필터 파라미터 추가
			if(context.state.animalType.length > 0){
				url += `&animal_type_num[]=${context.state.animalType.join('&animal_type_num[]=')}`;
			}

			// 시설 타입 필터 파라미터 추가
			if(context.state.facilityType.length > 0){
				url += `&facility_type_num[]=${context.state.facilityType.join('&facility_type_num[]=')}`;
			}

			// API 요청 실행
			axios.get(url)
			.then( response => {
				// 응답 데이터로 상태 업데이트
				context.commit('setPostResultCnt', response.data.PostListCnt);
				context.commit('setCurrentPage', response.data.PostList.current_page);
				context.commit('setPostList', response.data.PostList.data);

				// 첫 로드시에만 총 페이지 수 설정
				if(context.state.totalPage === 0){
					context.commit('setTotalPage', response.data.PostList.last_page);
				}
			}).catch (error => {
				// 에러 처리
				console.log(error);
				setErrorRouter(error.response.data, '/');
			}).finally(() => {
				// 로딩 상태 비활성화
				context.commit('setIsLoading', false);
			});
			
		}
		// index 페이지에 필요한 애들 가져오기
		// 메인 페이지에 표시할 포스트 데이터를 가져오는 액션
		,indexes(context, payload){
			// API 엔드포인트 URL 정의
			const url ='/api/posts/type';          // 최신순 데이터용 URL
			const urlView = '/api/posts/type?type=view';  // 조회수순 데이터용 URL  
			const urlLike = '/api/posts/type?type=like';  // 좋아요순 데이터용 URL

			// 조회수 기준 인기 게시물 데이터 요청
			axios.get(urlView)
			.then(response => {
				// 조회수 기준 게시물 목록을 상태에 저장
				context.commit('setViewList',response.data.PostList.data);
			}).catch(error => {
				console.log(error);
			});

			// 좋아요 기준 인기 게시물 데이터 요청
			axios.get(urlLike)
			.then(response => {
				// 좋아요 기준 게시물 목록을 상태에 저장
				context.commit('setLikeList',response.data.PostList.data);
			}).catch( error => {
				console.log(error);
			});

			// 최신 게시물 데이터 요청
			axios.get(url)
			.then(response => {
				// 최신 게시물 목록을 상태에 저장
				context.commit('setPostIndexList',response.data.PostList.data);
			}).catch(error => {
				console.log(error);
			});	
			
		}

		// 포스트 상세 출력
		,showPost(context, id){	
			// context.dispatch('auth/chkTokenAndContinueProcess', () => {
				
			// }, {root: true});
			context.commit('setInitialize');
			context.commit('setDetailIsLoading', true);
			
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
				context.commit('setAnimalFilter', response.data.AnimalType);
				context.commit('setFacilityFilter', response.data.FacilityType);

				// 지금 페이지랑 마지막 페이지가 같으면 setLastPageFlg true로 바꾸고 댓글더보기 버튼 없애기
				if(response.data.PostComment.current_page === response.data.PostComment.last_page) {
					context.commit('setLastPageFlg', true);
				}

				context.commit('setPostCommentCnt', response.data.PostCommentCnt);

				context.commit('setCurrentPage', response.data.PostComment.current_page);
				if(context.state.totalPage === 0) {
					context.commit('setTotalPage', response.data.PostComment.last_page);
				}
				// console.log(response.data.PostComment.data);
			})
			.catch(error => {
				if(error.response.status === 500) {
					alert('유효하지 않은 URL입니다.');
					router.replace('/posts');
				}
				console.error(error);
			}).finally(() => {
				context.commit('setDetailIsLoading', false);
			});	
		}

		// 포스트 댓글 작성
		,storePostComment(context, data) {
			context.dispatch('auth/chkTokenAndContinueProcess', () => {
				const url = '/api/posts/' + data.post_id;
				// const url = `/api/posts/${data.post_id}`;
				if(context.state.controllerFlg) {
					context.commit('setControllerFlg', false);
				}

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
					// alert('댓글을 작성하였습니다.');
					
					// console.log(response.data.postComment);
				})
				.catch(error => {
					console.log(error);
					if(error.response.status === 422) {
						alert('내용을 입력 해 주세요.');
					}
					// console.error('댓글 작성 실패');
					// console.error(error); // 서버의 에러 메시지 출력
				})
				.finally(() => {
					context.commit('setControllerFlg', true);
				});
			}, {root: true});
		}

		// 좋아요 클릭 기능 만들기
		,postClickLike(context, payload){

			context.dispatch('auth/chkTokenAndContinueProcess', () => {
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
			}, {root: true});
		}

		// 포스트 댓글 페이지네이션(작업중)
		,postCommentPagination(context, id) {
			// lastPageFlg 가 true일때는 밑에 처리를 하지 않는다.
			if(context.state.lastPageFlg === true){
				return;
			}

			context.commit('setIsLoading', true);
			if(context.state.controllFlg && !context.state.lastPageFlg) {
				context.commit('setControllerFlg', false);
			}
			const url = '/api/posts/' + id + '?page=' + context.getters['getCommentNextPage'];	// 페이지네이션 꼭?page 로 적어야함
			axios.get(url)
			.then(response => {
				// console.log('댓글 추가 요청', response.data.PostComment);
				context.commit('setPostCommentList', response.data.PostComment.data);
				context.commit('setCommentCurrentPage', response.data.PostComment.current_page);
				
				if(response.data.PostComment.current_page >= response.data.PostComment.last_page) {
					// console.log('마지막 페이지 도달 : ', response.data.PostComment.current_page, response.data.PostComment.last_page)
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
			context.dispatch('auth/chkTokenAndContinueProcess', () => {
				if(!confirm('댓글을 삭제하시겠습니까?')) {
					return;
				}
				if(context.state.controllerFlg) {
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
					// context.commit('deleteComment', id[1]);		// 프론트쪽 id배열의 1번을 삭제한다.
					// context.commit('subPostCommentCnt');		// 펫브리즈고 댓글갯수 -

					location.reload(true); 						// 새로고침
				})
				.catch(error => {
					console.error(error);
				})
				.finally(() => {
					context.commit('setControllerFlg', true);
				});
			}, {root: true});
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