import axios from '../../axios';
import router from "../../router";

export default {
	namespaced: true,
	state: () =>({
		boardList: []
		,LoadingFlg: false
		,links: []
		,currentPage: localStorage.getItem('freeCurrentPage') ? localStorage.getItem('freeCurrentPage') : 1	
		,freeDetail : {}
		,freeCommentList : []
		,freeComment : ''
		,commentCurrentPage : 1
		,commentPage : 0
		,freeCommentCnt : 0
		,controllerFlg : true
        ,lastPageFlg : false

		,indexCommunity : []
	}),
    mutations: {
		setBoardList(state, boardList) {
			state.boardList = boardList;
		},
		setFreeListUnshift(state,free) {
			state.boardList.unshift(free);
		},
		setLinks(state, links) {
			state.links = links;
		},		
        setCurrentPage(state, currentPage) {
            state.currentPage = currentPage;
            localStorage.setItem('freeCurrentPage', currentPage);
        },
		setLoadingFlg(state, flg) {
			state.LoadingFlg = flg;
		},
		setFreeDetail(state, freeDetail ) {
			state.freeDetail = freeDetail;
		},


		// 댓글관련
		setCommentCurrentPage(state, page) {
			state.commentCurrentPage = page;
		},
		// 자유 댓글 리스트
		setFreeCommentList(state, lists) {
			state.freeCommentList = state.freeCommentList.concat(lists);
		},
		// 자유 댓글 작성 최상위로 이동
		setFreeCommentListUnshift(state, comment) {
			state.freeCommentList.unshift(comment);
		},
		// 자유 댓글 페이지네이션
		setCommentPage(state, page) {
			state.commentPage = page;
		},
		// // 자유 댓글 갯수
		setFreeCommentCnt(state, count) {
			state.freeCommentCnt = count;
		},
		// 댓글갯수 +1
		addFreeCommentCnt(state) {
            state.freeCommentCnt += 1;
        },
		// 댓글 삭제(댓글의 key값을 받아서 삭제)
		deleteComment(state, key) {
			state.freeCommentList.splice(key, 1);  // splice로 key값받아서 1개 삭제
		},
		// 댓글갯수 -1
		subFreeCommentCnt(state) {
            state.freeCommentCnt -= 1;
        },
		// // 디바운싱
		setControllerFlg(state, flg) {
			state.controllerFlg = flg;
		},
        setIsLoading(state, flg){
			state.isLoading = flg;
		},
		setIndexCommunityList(state, data) {
			state.indexCommunity = data;
		}
    },
	actions: {
		freeBoardList(context, search) {
			context.commit('setLoadingFlg', true);

            const url = '/api/community/free?page=' + search.page + '&type=' + search.type + '&keyword=' + search.keyword;
            
            axios.get(url) 
            .then(response => {
                // console.log(response);
                context.commit('setBoardList', response.data.communityBoard.data);
                context.commit('setLoadingFlg', false);
                context.commit('setLinks', response.data.communityBoard.links);
                context.commit('setCurrentPage', response.data.communityBoard.current_page);
                // 로딩 상태 활성화
			    context.commit('setIsLoading', true);
				
				console.log(context.state.currentPage);
            })
            .catch(error=> {
                console.error(error);
            })
            .finally(() => {
				// 로딩 상태 비활성화
				context.commit('setIsLoading', false);
			});
        },
		freeBoardDetail(context, id) {
			context.commit('setLoadingFlg', true);
            
            const url = '/api/community/free/' + id ;

            axios.get(url)
            .then(response => {
                context.commit('setFreeDetail', response.data.communityBoardDetail);
               

                context.commit('setLoadingFlg', false);
            })    
            .catch(error => {
                console.error(error);
            });
        },		

		freeBoardStore(context, data) {
			context.commit('setLoadingFlg', true);

			const url = '/api/community/free/store';

			const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };

			const formData = new FormData();

			formData.append('title', data.title);
            formData.append('content', data.content);
            formData.append('user_id', data.userId);
            formData.append('community_type', data.communityType);

            axios.post(url, formData, config)
            .then(response => {
                // console.log(response);
                context.commit('setFreeListUnshift', response.data.showBoard.data);
                context.commit('setLoadingFlg', false);

				alert('글 작성을 완료했습니다.');

				// router.replace('/community/free');
				router.push('/community/free');
            })
            .catch(error => {
                console.error(error);
            })
		}

        

        // 자유 댓글 작성
	,storeFreetComment(context, data) {
		context.dispatch('auth/chkTokenAndContinueProcess', () => {
			const url = '/api/community/free/' + data.community_id;
			// const url = `/api/free/${data.community_id}`;
			if(context.state.controllerFlg) {
				context.commit('setControllerFlg', false);
			}

			const config = {
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
				}
			}

			const useData = {
				free_comment: data.free_comment,
			};
			// json으로 파싱
			const param = JSON.stringify(useData);

            

			axios.post(url, param, config)
			.then(response => {
				context.commit('setFreeCommentListUnshift', response.data.storeFreetComment);
				context.commit('addFreeCommentCnt');		// 펫브리즈고 댓글갯수 +
				// alert('댓글을 작성하였습니다.');
				
				// console.log(response.data.freeComment);
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
                	// 로딩 상태 비활성화
				context.commit('setIsLoading', false);

			});
		}, {root: true});
	}
	// 자유 댓글 페이지네이션(작업중)
	,freeCommentPagination(context, id) {
		// lastPageFlg 가 true일때는 밑에 처리를 하지 않는다.
		if(context.state.lastPageFlg === true){
			return;
		}

		context.commit('setIsLoading', true);
		if(context.state.controllFlg && !context.state.lastPageFlg) {
			context.commit('setControllerFlg', false);
		}
		const url = '/api/free/' + id + '?page=' + context.getters['getCommentNextPage'];	// 페이지네이션 꼭?page 로 적어야함
		axios.get(url)
		.then(response => {
			// console.log('댓글 추가 요청', response.data.PostComment);
			context.commit('setFreeCommentList', response.data.FreeComment.data);
			context.commit('setCommentCurrentPage', response.data.FreeComment.current_page);
			
			if(response.data.FreeComment.current_page >= response.data.FreeComment.last_page) {
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

	// 자유 댓글 삭제
	,freeCommentDelete(context, id) {
		context.dispatch('auth/chkTokenAndContinueProcess', () => {
			if(!confirm('댓글을 삭제하시겠습니까?')) {
				return;
			}
			if(context.state.controllerFlg) {
				context.commit('setControllerFlg', false);
			}
			const url = '/api/free/' + id[0];
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

	// 인덱스 커뮤니티 출력
	,indexCommunity(context ) {
		const url = 'api/index/community';
		// const config = {
		// 	params: {
		// 		category_theme_num: CategoryThemeNum
		// 	}
		// };
		axios.get(url)
		.then( response => {
			// 응답 데이터로 상태 업데이트
			context.commit('setIndexCommunityList', response.data.indexCommunity);
		}).catch (error => {
			// 에러 처리
			console.log(error);
		});
	}
  
}
	,getters: {
		getCommentNextPage(state) {
			return state.commentCurrentPage + 1;
		}
	}

}


