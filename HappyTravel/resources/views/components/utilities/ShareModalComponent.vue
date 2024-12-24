<template>
	<!-- 공유모달 -->
	<div v-show="isOpen" class="modal-box">
		<div class="modal-content">
			<h2>공유하기</h2>
                <div class="sns-box">
                    <button type="button" id="shareX" class="btn-icon">
                        <img class="icon" src="/developImg/x.png" alt="">
                        <p>X</p>
                    </button> 
	                <button type="button" id="shareKakao" class="btn-icon">
                        <img class="icon" src="/developImg/kakao.png" alt="">
                        <p>카카오톡</p>
                    </button>  
                    <button type="button" id="shareFacebook" class="btn-icon">
                        <img class="icon" src="/developImg/facebook.png" alt="">
                        <p>페이스북</p>
                    </button>   
                </div>
            <div class="copy">
                <p class="copyUrl">{{ test }}</p>
                <button class="btn-copy btn-bg-blue" @click="copy">복사</button>
            </div>
            <button @click="props.onClickClose" class="btn btn-header">닫기</button>
		</div>
	</div>
</template>

<script setup>
import { defineProps } from 'vue';
const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    onClickClose : Function
});

window.onload = function() {
    // X
	const btnShareX = document.querySelector('#shareX');
    if(btnShareX) {
        btnShareX.addEventListener('click', () => {
            const XUrl = window.location.href;
            const text = '펫브리즈고';
            window.open("https://twitter.com/intent/tweet?text=" + text + "&url=" + XUrl);
        });
    }
    // facebook
    const btnShareFacebook = document.querySelector('#shareFacebook');
	btnShareFacebook.addEventListener('click', () => {
		const FacebookUrl = window.location.href;
		window.open("http://www.facebook.com/sharer/sharer.php?u=" + FacebookUrl);
	})

    // // kakao
    // KakaoMap.init('88b9686891fe93d8f46cf1e55fa7f3ba');

    // // 카카오링크 버튼 생성
    // KakaoMap.Link.createDefaultButton({
    //     container: '#shareKakao',
    //     objectType: 'feed',
    //     content: {
    //         title: '펫브리즈고',
    //         description: '펫브리즈고 입니다.',
    //         KaKaoUrl = window.location.href,
    //         link: {
    //             mobileWebUrl: window.location.href,
    //             webUrl: window.location.href,
    //         }
    //     }
    // });
};



let test = window.location.href;

const copy = function(){
    navigator.clipboard.writeText(test);
    alert('복사완료');
}
</script>

<style scoped>
.modal-box {
    position: fixed;
    display: flex;
    align-items: center;
    justify-content: center;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    width: 100vw;
    height: 100vh;
}

.modal-content {
    width: 40%;
    background-color: #fff;
    padding: 20px;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.copy {
    display: flex;
    justify-content: center;
    border: 2px solid #cacaca;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.copyUrl {
    margin-right: 10px;
}

.btn-copy {
    width: 50px;

    border: none;
    border-radius: 20px;
    cursor: pointer;
}

.sns-box {
    display: flex;
    justify-content: center;
    margin: 20px
}

.btn-icon {
    display: inline-block;
    border: none;
    background-color: transparent;
    padding: 10px;
}

.icon {
    width: 50px;
    cursor: pointer;
    margin: 10px;
}
</style>