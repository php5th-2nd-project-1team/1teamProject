import axios from '../../axios';
import router from '../../router';
export default {
	namespaced: true,
	state: () =>({
		noticeList: []
        ,noticePage: 0
        ,LoadingFlg:false
        ,links: []        
        ,currentPage: 0
        ,noticeDetail: {}
	})
	,mutations: {
        setNoticeList(state, noticeList) {
            state.noticeList = noticeList;
        },
        setNoticePage(state, noticePage) {
            state.noticePage = noticePage;
        }
        ,setLoadingFlg(state, LoadingFlg) {
            state.LoadingFlg = LoadingFlg;
        }
        ,setLinks(state, links) {
            state.links = links;
        },
        setCurrentPage(state, currentPage) {
            state.currentPage = currentPage;
        },
        setNoticeDetail(state, noticeDetail) {
            state.noticeDetail = noticeDetail;
        }
	}   
	,actions: {
        noticeList(context) {
            context.commit('setLoadingFlg', true);
            const url = '/api/community/notice';
            
            axios.get(url) 
            .then(response => {
                console.log(response);
                context.commit('setNoticeList', response.data.notice.data);
                context.commit('setLoadingFlg', false)
                context.commit('setLinks', response.data.notice.links);
            })
            .catch(error=> {
                console.error(error);
            })
        },

        noticeLinkList(context, url) {

            axios.get(url) 
            .then(response => {
                context.commit('setNoticeList', response.data.notice.data);
                context.commit('setLinks', response.data.notice.links);
                context.commit('setCurrentPage', response.data.notice.current_page);
                context.commit('setLoadingFlg', false);
            })
            .catch(error=> {
                console.error(error);
            })
        },
        noticeDetailList(context, id) {
           
            const url = '/api/community/notice/detail/' + id;
            axios.get(url)
            .then(response => {
                context.commit('setNoticeDetail', response.data.noticeDetail);
                console.log(response.data.noticeDetail);

                router.replace('/community/notice/detail');
            })    
            .catch(error => {
                console.error(error);
            });
        }
	}
	,getters: {
		
	}
}