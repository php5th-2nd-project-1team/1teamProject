import axios from '../../axios';
// import router from '../../router';
export default {
	namespaced: true,
	state: () =>({
		noticeList: []
        ,LoadingFlg: false
        ,links: []        
        ,currentPage: localStorage.getItem('noticeCurrentPage') ? localStorage.getItem('noticeCurrentPage') : 1
        ,noticeDetail: {}
        ,noticeNomal : []
        ,noticeImportant: []
	})
	,mutations: {
        setNoticeList(state, noticeList) {
            state.noticeList = noticeList;
        },
        setNoticeListUnshift(state, notice) {
            state.noticeList.unshift(notice);
        }
        ,setLoadingFlg(state, LoadingFlg) {
            state.LoadingFlg = LoadingFlg;
        }
        ,setLinks(state, links) {
            state.links = links;
        }
        ,setCurrentPage(state, currentPage) {
            state.currentPage = currentPage;
            localStorage.setItem('noticeCurrentPage', currentPage);
        }
        ,setNoticeDetail(state, noticeDetail) {
            state.noticeDetail = noticeDetail;
        }
        ,setNoticeImportant(state, noticeImportant) {
            state.noticeImportant = noticeImportant;
        }
	}   
	,actions: {
        noticeList(context, page) {
            context.commit('setLoadingFlg', true);

            page = page === 0 ? context.state.currentPage : page;
            const url = '/api/community/notice?page=' + page;
            
            axios.get(url) 
            .then(response => {
                // console.log(response);
                context.commit('setNoticeList', response.data.noticeListPageNomal.data);
                context.commit('setNoticeImportant', response.data.noticeListPageimportant);
                context.commit('setLoadingFlg', false);
                context.commit('setLinks', response.data.noticeListPageNomal.links);
                context.commit('setCurrentPage', response.data.noticeListPageNomal.current_page);
            })
            .catch(error=> {
                console.error(error);
            })
        },
        noticeDetailList(context, id) {
            context.commit('setLoadingFlg', true);
            
            const url = '/api/community/notice/' + id ;

            axios.get(url)
            .then(response => {
                context.commit('setNoticeDetail', response.data.noticeDetail);
                // console.log(response.data.noticeDetail);

                context.commit('setLoadingFlg', false);
            })    
            .catch(error => {
                console.error(error);
            });
        },
        
	}
	,getters: {
		
	}
}