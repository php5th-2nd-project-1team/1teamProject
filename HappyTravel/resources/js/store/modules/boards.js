import axios from '../../axios';
import router from "../../router";

export default {
	namespaced: true,
	state: () => ({
		boardList: [],
		LoadingFlg: false,
		links: [],
		currentPage: localStorage.getItem('freeCurrentPage') ? localStorage.getItem('freeCurrentPage') : 1,
		freeDetail: {},
		freeCommentList: [],
		freeComment: '',
		commentCurrentPage: 1,
		commentPage: 0,
		freeCommentCnt: 0,
		controllerFlg: true,
		lastPageFlg: false,
		indexCommunity: [],
		showoffList: [],
	}),
	mutations: {
		// 게시판 목록 설정
		setBoardList(state, boardList) {
			state.boardList = boardList;
		},
		// 새 게시글을 목록 최상단에 추가
		setFreeListUnshift(state, free) {
			state.boardList.unshift(free);
		},
		// 페이지네이션 링크 설정
		setLinks(state, links) {
			state.links = links;
		},
		// 현재 페이지 설정 및 로컬스토리지 저장
		setCurrentPage(state, currentPage) {
			state.currentPage = currentPage;
			localStorage.setItem('freeCurrentPage', currentPage);
		},
		// 로딩 상태 설정
		setLoadingFlg(state, flg) {
			state.LoadingFlg = flg;
		},
		// 게시글 상세 정보 설정
		setFreeDetail(state, freeDetail) {
			state.freeDetail = freeDetail;
		},

		// 댓글 관련 mutations
		setCommentCurrentPage(state, page) {
			state.commentCurrentPage = page;
		},
		// 댓글 목록 설정
		setFreeCommentList(state, lists) {
			state.freeCommentList = state.freeCommentList.concat(lists);
		},
		// 새 댓글을 목록 최상단에 추가
		setFreeCommentListUnshift(state, comment) {
			state.freeCommentList.unshift(comment);
		},
		// 댓글 페이지 설정
		setCommentPage(state, page) {
			state.commentPage = page;
		},
		// 댓글 총 개수 설정
		setFreeCommentCnt(state, count) {
			state.freeCommentCnt = count;
		},
		// 댓글 개수 증가
		addFreeCommentCnt(state) {
			state.freeCommentCnt += 1;
		},
		// 댓글 삭제
		deleteComment(state, key) {
			state.freeCommentList.splice(key, 1);
		},
		// 댓글 초기화
		resetCommentsList(state){
			state.freeCommentList=[];
		},
		// 댓글 개수 감소
		subFreeCommentCnt(state) {
			state.freeCommentCnt -= 1;
		},
		// 컨트롤러 플래그 설정
		setControllerFlg(state, flg) {
			state.controllerFlg = flg;
		},
		// 로딩 상태 설정
		setIsLoading(state, flg) {
			state.isLoading = flg;
		},
		// 인덱스 커뮤니티 목록 설정
		setIndexCommunityList(state, data) {
			state.indexCommunity = data;
		},
		// 자랑 게시판 리스트
		setShowoffList(state, data) {
			state.showoffList = data;
		},
		// 자랑 게시판 다음페이지 추가
		setConcatShowoffList(state, data) {
			state.showoffList = state.showoffList.concat(data);
		},
		setCommunityFreeUpdate(state, data) {
			state.CommunityFreeUpdate = data;
		},
	},
	actions: {
		// 게시판 목록 조회
		freeBoardList(context, search) {
			context.commit('setLoadingFlg', true);

			const url = '/api/community/free?page=' + search.page + '&type=' + search.type + '&keyword=' + search.keyword;

			axios.get(url)
				.then(response => {
					context.commit('setBoardList', response.data.communityBoard.data);
					context.commit('setLoadingFlg', false);
					context.commit('setLinks', response.data.communityBoard.links);
					context.commit('setCurrentPage', response.data.communityBoard.current_page);
					context.commit('setIsLoading', true);

					console.log(context.state.currentPage);
				})
				.catch(error => {
					console.error(error);
				})
				.finally(() => {
					context.commit('setIsLoading', false);
				});
		},

		// 게시글 상세 조회
		freeBoardDetail(context, id) {
			context.commit('setLoadingFlg', true);
			context.commit('resetCommentsList');
			const url = '/api/community/free/' + id;

			axios.get(url)
				.then(response => {
					context.commit('setFreeDetail', response.data.communityBoardDetail);
					context.commit('setFreeCommentCnt', response.data.CommuntiyCommentCnt.cnt);
					context.commit('setFreeCommentList', response.data.CommunityComment);
					context.commit('setLoadingFlg', false);
				})
				.catch(error => {
					console.error(error);
				});
		},

		// 자유 게시글 작성
		freeBoardStore(context, data) {
			context.commit('setLoadingFlg', true);

			const url = '/api/community/free/store';
			const config = {
				headers: {
					'Content-Type': 'multipart/form-data',
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			};

			const formData = new FormData();
			formData.append('title', data.title);
			formData.append('content', data.content);
			formData.append('user_id', data.userId);
			formData.append('community_type', data.communityType);

			axios.post(url, formData, config)
				.then(response => {
					context.commit('setFreeListUnshift', response.data.showBoard.data);
					context.commit('setLoadingFlg', false);
					alert('글 작성을 완료했습니다.');
					router.push('/community/free');
				})
				.catch(error => {
					console.error(error);
				});
		}, 
		//  자유 게시글 수정
		freeBoardUpdate(context, data) {
			context.commit('setLoadingFlg', true);
			const url ='/api/community/free/' + data.community_id;

			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			};
			
			axios.put(url, data, config)
			.then(response => {
				context.commit('setCommunityFreeUpdate',response.data.communityFree.data);
				context.commit('setLoadingFlg', false);
			})
			.catch(error => {
				console.error(error);
			});
		},
		// 자유 게시글 삭제
		freeBoardDelete(context, id) {
			context.dispatch('auth/chkTokenAndContinueProcess', ( )=>{
				if (context.state.controllerFlg) {
					context.commit('setControllerFlg', false);
				}
				const url = '/api/community/free/' + id;
				const config = {
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
					}
				};
	
				axios.delete(url, config) 
				.then(response=> {
					alert('게시글이 삭제 되었습니다.');
				})
				.catch(error => {
					console.error(error);
				})
				.finally(() => {
					context.commit('setControllerFlg', true);
				});
			}, { root: true });
		} , 
		
		// 댓글 작성
		storeFreeComment(context, data) {
			context.dispatch('auth/chkTokenAndContinueProcess', () => {
				if(context.state.isLoading){
					return;
				}
	
				if (!data.comment_content || !data.community_id) {
					alert('필수 정보가 부족합니다.');
					return;
				}

				const url = '/api/community/free/store/' + data.community_id;

				if (context.state.controllerFlg) {
					context.commit('setControllerFlg', false);
				}

				context.commit('setIsLoading', true);

				const config = {
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
					}
				};

				axios.post(url, data, config)
					.then(response => {
						context.commit('setFreeCommentListUnshift', response.data.storeFreeComment);
						context.commit('addFreeCommentCnt');
						console.log('서버 응답:', response);
					})
					.catch(error => {
						console.log(error);
						if (error.response) {
							console.log('서버 오류:', error.response);
							if (error.response.status === 422) {
								alert('내용을 입력 해 주세요.');
							} else {
								alert(`오류가 발생했습니다: ${error.response.status}`);
							}
						} else {
							alert('네트워크 오류가 발생했습니다.');
						}
					})
					.finally(() => {
						context.commit('setControllerFlg', true);
						context.commit('setIsLoading', false);
					});
			}, { root: true });
		},

		// 댓글 페이지네이션 TODO 미구현
		freeCommentPagination(context, id) {
			if (context.state.lastPageFlg === true) {
				return;
			}

			context.commit('setIsLoading', true);
			if (context.state.controllFlg && !context.state.lastPageFlg) {
				context.commit('setControllerFlg', false);
			}

			const url = '/api/free/' + id + '?page=' + context.getters['getCommentNextPage'];

			axios.get(url)
				.then(response => {
					console.log(response.data);
					context.commit('setFreeCommentList', response.data.FreeComment.data);
					context.commit('setCommentCurrentPage', response.data.FreeComment.current_page);

					if (response.data.FreeComment.current_page >= response.data.FreeComment.last_page) {
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
		},

		// 댓글 삭제
		freeCommentDelete(context, id) {
			context.dispatch('auth/chkTokenAndContinueProcess', () => {
				if (!confirm('댓글을 삭제하시겠습니까?')) {
					return;
				}

				if (context.state.controllerFlg) {
					context.commit('setControllerFlg', false);
				}

				const url = '/api/community/free/destroy/' + id[0];
				const config = {
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
					}
				};

				axios.post(url, {}, config)
					.then(response => {
						alert('댓글이 삭제되었습니다.');
						location.reload(true);
					})
					.catch(error => {
						console.error(error);
					})
					.finally(() => {
						context.commit('setControllerFlg', true);
					});
			}, { root: true });
		},

		// 인덱스 커뮤니티 조회
		indexCommunity(context) {
			const url = 'api/index/community';

			axios.get(url)
				.then(response => {
					context.commit('setIndexCommunityList', response.data.indexCommunity);
				})
				.catch(error => {
					console.log(error);
				});
		}
		,CommunityShowoffPagination(context, page) {
			const url = '/api/community/showoff?page=' + page;

			axios.get(url)
			.then(response => {
				console.log(response.data);
				if(page < 2) {
					context.commit('setShowoffList', response.data.communityShowoff.data);
				} else {
					context.commit('setConcatShowoffList', response.data.communityShowoff.data);
				}
			})
			.catch(error => {
				console.error(error);
			});
		}
	},
	getters: {
		getCommentNextPage(state) {
			return state.commentCurrentPage + 1;
		}
	}
}
