
import router from "../../router";

export default {
	namespaced: true,
	state: () =>({
		boardList: []
		,LoadingFlg: false
		,links: []
		,currentPage: localStorage.getItem('freeCurrentPage') ? localStorage.getItem('freeCurrentPage') : 1	
		,freeDetail : {}
	})
	,mutations: {
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
		}
     

	}
	,actions: {
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
				
				console.log(context.state.currentPage);
            })
            .catch(error=> {
                console.error(error);
            })
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
  
	}
	,getters: {
			
	}
}