import router from "../../router";

export default {
	namespaced: true,
	state: () =>({

	})
	,mutations: {

	}
	,actions: {
		NoticeBoardStore(context, data) {
            const url = '/api/community/notice';

            const config = {
                headers : {
                    'Content-Type' : 'multipart/form-data',
                    'Authorization' : 'Bearer ' + localStorage.getItem('accessToken'),
                }
            };

            const formData = new FormData();
                formData.append('notice_content', data.content);
                formData.append('notice_title', data.title);

            axios.post(url, formData, config)
            .then(response => {
                context.commit('notice/setNoticeListUnshift', response.data.notice, { root: true });
                
                router.push('/community/notice');
            })
            .catch(error => {
                console.log(error);
            })
            
        }
	}
	,getters: {
		
	}
}



