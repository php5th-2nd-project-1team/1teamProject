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
     

	}
	,actions: {
		freeBoardList(context, page) {

            page = page === 0 ? context.state.currentPage : page;
            const url = '/api/community/free?page=' + page;
            
            axios.get(url) 
            .then(response => {
                // console.log(response);
                context.commit('setBoardList', response.data.boardList.data);
                context.commit('setLoadingFlg', false);
                context.commit('setLinks', response.data.boardList.links);
                context.commit('setCurrentPage', response.data.boardList.current_page);
            })
            .catch(error=> {
                console.error(error);
            })
        },
  
	}
	,getters: {
			
	}
}