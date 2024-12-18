import axios from '../../axios';
import router from '../../router';
export default {
	namespaced: true,
	state: () =>({
		noticeList: []
        ,noticePage: 0
        ,LoadingFlg:false
        ,links: []        
        ,currentPage: localStorage.getItem('noticeCurrentPage') ? localStorage.getItem('noticeCurrentPage') : 1
        ,noticeDetail: {}
	})
	,mutations: {
        setNoticeList(state, noticeList) {
            state.noticeList = noticeList;
        }
        ,setNoticePage(state, noticePage) {
            state.noticePage = noticePage;
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
	}   
	,actions: {
        noticeList(context, page) {
            context.commit('setLoadingFlg', true);

            page = page === 0 ? context.state.currentPage : page;
            const url = '/api/community/notice?page=' + page;
            
            axios.get(url) 
            .then(response => {
                console.log(response);
                context.commit('setNoticeList', response.data.notice.data);
                context.commit('setLoadingFlg', false)
                context.commit('setLinks', response.data.notice.links);
                context.commit('setCurrentPage', response.data.notice.current_page);
            })
            .catch(error=> {
                console.error(error);
            })
        },
        noticeDetailList(context, id) {
           
            const url = '/api/community/notice/' + id;
            axios.get(url)
            .then(response => {
                context.commit('setNoticeDetail', response.data.noticeDetail);
                console.log(response.data.noticeDetail);

                router.push('/community/notice/' + id);
            })    
            .catch(error => {
                console.error(error);
            });
        },

        
	}
	,getters: {
		
	}
}