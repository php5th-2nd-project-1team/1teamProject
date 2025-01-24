export default {
	namespaced: true,
	state: () =>({
		// 모달창 관련
		isModalOpen : false,
		reservationData : {},
		shopBoardList: [],
		LoadingFlg: false,
		currentPage: 0,
		lastPage: 0,
		lastPageFlg: false,
		currentSave: '',
		shopBoardDetail: [],
		animalInfos: [
			{ animalType: '소형견', animalPrecautions: '' },
		  ],
		peopleCount: 1,
		
	})
	,mutations: {
		setPeopleCountUp(state) {
			state.peopleCount++;
		},
		setPeopleCountDown(state) {
			if(state.peopleCount > 1){
				state.peopleCount--;
			}
		},
		setIsModalOpen(state, value){
			state.isModalOpen = value;
		},
		setShopBoardList(state, shopBoardList) {
			state.shopBoardList = shopBoardList;
		},
		setLoadingFlg(state, flg) {
			state.LoadingFlg = flg;
		},
		setLastPage(state, page) {
			state.lastPage = page;
		},
		setLastPageFlg(state, flg) {
			state.lastPageFlg = flg;
		},
		setCurrentSave(state, save) {
			state.currentSave = save;
		},
		setCurrentPage(state, page) {
			state.currentPage = page;
		},
		setShopBoardDetail(state, board) {
			state.shopBoardDetail = board;
		},
		ADD_ANIMAL_INFO(state, animalInfo) {
			state.animalInfos.push(animalInfo);
		},
		REMOVE_ANIMAL_INFO(state) {
		if (state.animalInfos.length > 1) {
			state.animalInfos.pop();
		}
		},
		UPDATE_ANIMAL_INFO(state, { index, animalInfo }) {
		state.animalInfos[index] = animalInfo;
		},
	}
	,actions: {
		

		reservation(context, payload){
			console.log(payload);
		},

		shopBoardList(context, current) {
			// if(context.state.lastPageFlg) {
			// 	return;
			// }

			context.commit('setCurrentSave', current);

			context.commit('setLoadingFlg', true);

            const url = `/api/shops/?current=${current}&page=${context.getters['getNextPage']}`;
            
            axios.get(url) 
            .then(response => {
                // console.log(response);
                context.commit('setShopBoardList', response.data.shopBoardList.data);
				context.commit('setLastPage', response.data.shopBoardList.last_page);
				context.commit('setCurrentPage', response.data.shopBoardList.current_page);
				if(context.state.lastPage === context.state.currentPage) {
					context.commit('setLastPageFlg', true);
				}
				console.log(response.data.shopBoardList.data);
                context.commit('setLoadingFlg', false);
            })
            .catch(error=> {
                console.error(error);
            })
		},

		shopBoardDetail(context, id) {
			context.commit('setLoadingFlg', true);

			const url = `/api/shops/${id}`;

			axios.get(url) 
            .then(response => {
                // console.log(response);
                context.commit('setShopBoardDetail', response.data.shopBoardDetail);
				// console.log(response.data.shopBoardList.data);
                context.commit('setLoadingFlg', false);
            })
            .catch(error=> {
                console.error(error);
            })
		},
		addAnimalInfo({ commit }) {
			commit('ADD_ANIMAL_INFO', { animalType: '소형견', animalPrecautions: '' });
		},
		discountAnimalInfo({ commit }) {
			commit('REMOVE_ANIMAL_INFO');
		},
		updateAnimalInfo({ commit }, payload) {
			commit('UPDATE_ANIMAL_INFO', payload);
		},

		async requestPayment({ commit }, paymentDetails) {
			try {
				console.log(paymentDetails);

				// 결제 요청: Laravel로 데이터 전송
				const response = await axios.post('/api/payment/request', paymentDetails);

				console.log(response);
				
				return response.data;

			} catch (error) {
			  	throw new Error('결제 요청 중 오류가 발생했습니다.');
			}
		  },
		
		  // 결제 승인 액션
		  async confirmPayment({ commit }, imp_uid) {
			try {

				const response = await axios.post('/api/payment/confirm', { imp_uid: imp_uid });

				return response.data;

			} catch (error) {

			 	throw new Error('결제 승인 중 오류가 발생했습니다.');

			}
		  },
	}
	,getters: {
		getNextPage(state){
			return state.currentPage + 1;
		}
	}
}