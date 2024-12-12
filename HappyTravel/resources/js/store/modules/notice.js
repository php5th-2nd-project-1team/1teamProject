import axios from '../../axios';
export default {
	namespaced: true,
	state: () =>({
		noticeList: []
        ,noticePage:0
        ,LoadingFlg:false
        ,noticeDetailData : {title : '', content : '', img : '', maager_id:''}

	})
	,mutations: {
        setNoticeList(state, noticeList) {
            state.noticeList = state.noticeList.concat(noticeList);
        },
        setNoticePage(state, noticePage) {
            state.noticePage = noticePage;
        }
        ,setLoadingFlg(state, LoadingFlg) {
            state.LoadingFlg = LoadingFlg;
        }
	}   
	,actions: {
        noticeList(context) {
            context.commit('setLoadingFlg', true);
            const url = '/api/community/notice';
            
            axios.get(url) 
            .then(response => {
                console.log(response.data);
                context.commit('setNoticeList', response.data.notice.data);
                context.commit('setLoadingFlg', false)
            })
            .catch(error=> {
                console.error(error);
            })
        }
	}
	,getters: {
		
	}
}