export default {
	namespaced: true,
	state: () =>({
		boardList: []
	})
	,mutations: {
		setBoardList(state, boardList) {
			state.boardList = boardList;
		},

	}
	,actions: {
	
	}
	,getters: {
		
	}
}