export default {
	namespaced: true,
	state: () =>({
		// 모달창 관련
		isModalOpen : false,
		reservationData : {},
	})
	,mutations: {
		setIsModalOpen(state, value){
			state.isModalOpen = value;
		},
	}
	,actions: {
		reservation(context, payload){
			console.log(payload);
		}
	}
	,getters: {
		
	}
}