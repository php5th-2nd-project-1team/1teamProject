export default {
	namespaced: true,
	state: () =>({
		boardList: []
		,LoadingFlg: false
		,links: []
		,currentPage: localStorage.getItem('freeCurrentPage') ? localStorage.getItem('freeCurrentPage') : 1	
	})
	,mutations: {
		setBoardList(state, boardList) {
			state.boardList = boardList;
		},
		setFreeListUnshift(state,free) {
			state.freeList.unshift(free);
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
  
	}
	,getters: {
			
	}
}