import axios from "axios";

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

		indexShop: [],
		isLikeLoading: false,
		isClkedLike : null,
		
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

		setIndexShopList(state, data) {
			state.indexShop = data;
		},
		// 좋아요 로딩 여부
		setIsLikeLoading(state, flg) {
			state.isLikeLoading = flg;
		},
		// 좋아요 여부 
		setIsClkedLike(state, flg){
			state.isClkedLike = flg;
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

		//   상품 좋아요 클릭여부
		classLike(context, id) {
			context.dispatch('auth/chkTokenAndContinueProcess', () => {
				if(context.state.isLikeLoading) {
					return;
				}

				context.commit('isLikeLoading', true);

				const url = '/api/shops/like/' + id;
				const data = JSON.stringify({
					class_likes_flg: !context.state.isClkedLike
				});

				const config = {
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
					}
				}

				axios.post(url, data, config)
				.then(response => {
					context.commit('setIsClkedLike', response.data.like_flg.class_likes_flg === '1' ? true : false);
				}).catch(error => {
					console.log(error.response);
				}).finally(() => {
					context.commit('isLikeLoading', false);
				});
			}, {root: true});
		},

		// 인덱스 상품 전체 출력
		indexShop(context) {
			const url = 'api/index/shop';
			// const config = {
			// 	params: {
			// 		category_theme_num: CategoryThemeNum
			// 	}
			// };
			axios.get(url)
			.then( response => {
				// 응답 데이터로 상태 업데이트
				context.commit('setIndexShopList', response.data.IndexShop);
				// console.log(response.data.IndexShop);
			}).catch (error => {
				// 에러 처리
				console.log(error);
			});
		}
	}
	,getters: {
		getNextPage(state){
			return state.currentPage + 1;
		}
	}
}