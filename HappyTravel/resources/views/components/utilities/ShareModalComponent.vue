<template>
	<!-- 공유모달 -->
	<div class="modal-box">
		<div class="modal-content">
			<h2>공유하기</h2>
                <div class="sns-box">
                    <button type="button" @click="XShare" class="btn-icon">
                        <img class="icon" src="/developImg/x.png" alt="">
                        <p>X</p>
                    </button> 
	                <button type="button" @click="kakaoShare" class="btn-icon">
                        <img class="icon" src="/developImg/kakao.png" alt="">
                        <p>카카오톡</p>
                    </button>  
                    <button type="button" @click="NaverShare" class="btn-icon naver">
                        <img class="icon" src="/developImg/naver.png" alt="">
                        <p>네이버</p>
                    </button>      
                    <button type="button" @click="FacebookShare" class="btn-icon">
                        <img class="icon" src="/developImg/facebook.png" alt="">
                        <p>페이스북</p>
                    </button>
                </div>
            <div class="copy">
                <p ref="textElement" class="copyUrl">{{ pageUrl }}</p>
                <button class="btn-copy btn-bg-blue" @click="copy">복사</button>
            </div>
            <button @click="$emit('eventClickClose')" class="btn btn-header">닫기</button>
		</div>
	</div>
</template>

<script setup>
if(!Kakao.isInitialized()) {
    Kakao.init('88b9686891fe93d8f46cf1e55fa7f3ba');
}

const kakaoShare = () => {
    const currentURL = window.location.href;
    Kakao.Link.sendDefault({
        objectType: 'feed',
        content: {
            title: 'PetBreeze',
            description: '#펫브리즈고 입니다.',
            imageUrl: '/developImg/kakao.png',
            link: {
                mobileWebUrl: currentURL,
                webUrl: currentURL,
            },
        },
        buttons: [
            {
                title: '웹으로 보기',
                link: {
                    mobileWebUrl: currentURL,
                    webUrl: currentURL,
                },
            },
        ],
        // 카카오톡 미설치 시 카카오톡 설치 경로이동
        installTalk: true,
    });
}

const XShare = () => {
    const XUrl = encodeURIComponent(window.location.href);
    const XText = encodeURIComponent('#펫브리즈고');
    const XshareLink = `https://twitter.com/intent/tweet?text=${XText}&url=${XUrl}`
    window.open(XshareLink, '_blank');
    // console.log(XshareLink);
    // window.open("https://twitter.com/intent/tweet?text=" + XText + "&url=" + XUrl);
}

const FacebookShare = () => {
    const FacebookUrl = window.location.href;
    const FacebookText = '펫브리즈고';
    window.open("http://www.facebook.com/sharer/sharer.php?u=" + FacebookUrl + "&t=" + FacebookText )
}

const NaverShare = () => {
    const NaverUrl = encodeURIComponent(window.location.href);
    const NaverTitle = encodeURI('펫브리즈고');
    const NaverShareLink = "https://share.naver.com/web/shareView?url=" + NaverUrl + "&title=" + NaverTitle;
    window.open(NaverShareLink, '_blank');
    // document.location = NaverShareLink;
}
let pageUrl = window.location.href;

const copy = function(){
    navigator.clipboard.writeText(pageUrl);
    alert('복사완료');
}

window.onload = function() {
    // X
	// const btnShareX = document.querySelector('#shareX');
    // if(btnShareX) {
    //     btnShareX.addEventListener('click', () => {
    //         const XUrl = window.location.href;
    //         const XText = '펫브리즈고';
    //         window.open("https://twitter.com/intent/tweet?text=" + XText + "&url=" + XUrl);
    //     });
    // }

    // facebook
    // const btnShareFacebook = document.querySelector('#shareFacebook');
	// btnShareFacebook.addEventListener('click', () => {
	// 	const FacebookUrl = window.location.href;
    //     const FacebookText = '펫브리즈고';
	// 	window.open("http://www.facebook.com/sharer/sharer.php?u=" + FacebookUrl + "&t=" + FacebookText )
    //     });


    // const btnShareKakao = document.querySelector('#shareKakao');
    // btnShareKakao.addEventListener('click', () => {

    //     const currentURL = window.location.href;
    //     Kakao.Link.sendDefault({
    //         objectType: 'feed',
    //         content: {
    //             title: 'PetBreeze',
    //             description: '#펫브리즈고 입니다.',
    //             imageUrl: '/developImg/kakao.png',
    //             link: {
    //                 mobileWebUrl: currentURL,
    //                 webUrl: currentURL,
    //             },
    //         },
    //         buttons: [
    //             {
    //                 title: '웹으로 보기',
    //                 link: {
    //                     mobileWebUrl: currentURL,
    //                     webUrl: currentURL,
    //                 },
    //             },
    //         ],
    //         // 카카오톡 미설치 시 카카오톡 설치 경로이동
    //         installTalk: true,
            
    //     });
    //     // Kakao 초기화(카카오 오류가 나요... )
    //     // 에러: Kakao.init: Already initialized
    //     // Kakao.init('코드')가 한번만 실행해야될거같아서 밖으로빼고 한번만 실행하게 함
    //     // onMounted(() => {
    //     //     if (!window.Kakao.isInitialized()) {
    //     //         window.Kakao.init('88b9686891fe93d8f46cf1e55fa7f3ba');
    //     //         console.log('Kakao SDK initialized');
    //     //     } else {
    //     //         console.log('Kakao SDK already initialized');
    //     //         return;
    //     //     }
    //     // });
    // })

};
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
    z-index: 10000;
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

.naver {
    padding: 0;
}
</style>