<template>
    <h1>자랑게시판</h1>

    <div class="showoff-content-contaier">
            <p class="showoff-content-title">
                제목
            </p>
        <div class="showoff-content-info">
            <span>
                <img class="user-profile"src="/developImg/kakao.png" alt="">
            </span>
            <span class="user-nickname">
                푸헤헤
            </span>
        </div>
        <div class="showoff-content-slide-container">
            <img src="/developImg/kakao.png" alt="">
        </div>
        <div class="btn-radius-wrap">
            <button></button>
            <button></button>
            <button></button>
        </div>
        <div class="showoff-content-footer">
            <button class="showoff-likes-btn">
                <img class="showoff-likes"src="/developImg/like_yes.png" alt="좋아요">
            </button>
            <div class="showoff-like-count-container">
                <span class="like-count">
                    6868 likes
                </span>
            </div>
            <div class="showoff-content-text">
                <p class="showoff-contet">
                    게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용
                    게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용
                    게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용
                    게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용
                    게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용게시글 내용
                </p>
            </div>
        </div>
    </div>  
        <br><br><br><br><br>
        <hr>
        <br><br><br><br><br>
    <div class="showoff-comment-container">
        <!-- 댓글 리스트 -->
            <div class="showoff-comment-title">
                <h3>펫브리즈 톡 <span>댓글 갯수: 1</span></h3>
            </div>
    
            <!-- 댓글 작성 부분 -->
            <div class="showoff-comment-form-box">
                <textarea 
                    :placeholder="placeholder"				
                    minlength="1"
                    maxlength="200"
                ></textarea>
                <button 				
                    class="btn-showoff-comment btn-bg-blue"
                    type="button"
                >등록</button>
            </div>
        <CommunityCommnet />
    </div>
    
</template>
<script setup>
    import CommunityCommnet from './CommunityCommnet.vue';
</script>
<style scoped>
    h1 { 
        text-align: center;
        margin-top: 20px;
    }
    hr {
        width: 80%;
        margin: 0 auto;
    }
    /* 자랑게시판 전체 컨테이너 */
    .showoff-content-contaier  {
        width: 80%;
        margin: 0 auto;
        margin-top: 50px;
    }
    /* 자랑게시판 컨텐츠 제목 */
    .showoff-content-title {
        margin-bottom: 20px;
        font-size: 2rem;
    }
    /* 자랑게시판 컨텐츠 정보 */
    .showoff-content-info {
    display: flex;
    align-items: center; /* 세로 중앙 정렬 */
    gap: 15px; /* 이미지와 닉네임 간격 추가 */
    }   
    /* 자랑게시판 유저 프로필 */
    .user-profile {
        width: 40px; /* 이미지 크기 조절 */
        height: 40px;
        border-radius: 50%; /* 동그랗게 */
    }
    /* 자랑게시판 유저 닉네임 */
    .user-nickname {
        font-size: 1.1rem;
        font-weight: bold;
        display: flex;
        align-items: center; /* 세로 중앙 정렬 */
    }
    /* 자랑게시판 컨텐츠 슬라이드 컨테이너 */
    .showoff-content-slide-container {
        width:100%;
        height: 100%;
        background-color: green;
        text-align: center;
    } 
    .btn-radius-wrap  {
        display: flex;
        margin: 20px;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }
    .btn-radius-wrap >button {
        border-radius: 50%;
        width: 20px; /* 버튼 크기 */
        height: 20px;
        border:none;        
        cursor: pointer;
    }

    
    
    /* 자랑게시판 컨텐츠 footer */ 
    .showoff-content-footer {      
    margin: 0 auto;
    }
    .showoff-likes-btn {
        border: none;
        cursor: pointer;
        background: none; /* 배경 없애기 */
    }
    .showoff-likes {
        
        width: 40px;
        height: 40px;
    }

    /* 좋아요 개수와 게시글 내용을 감싸는 영역 */
    .showoff-like-count-container {
        display: flex;
        flex-direction: row;
        margin-top: 10px;
    }


    .showoff-comment-container {
        width: 80%;
        margin: 0 auto;
    }
    .showoff-comment-title {
		font-size: 30px;
		margin-bottom: 20px;
	}
	
	.showoff-comment-title span {
		color: #2986FF;
	}
	
	.showoff-comment-form-box {
		width: 100%;
		padding: 20px;
		display: grid;
		background-color: #CDECFF;
	}
	
	.showoff-comment-form-box > textarea {
		border: none;
		resize: none;
		width: 100%;
		height: 10em;
		font-size: 15px;
		padding: 10px;
		margin-bottom: 10px;
	}
	
	.btn-showoff-comment {
		width: 100px;
		padding: 10px;
		font-size: 20px;
		border: none;
		cursor: pointer;
		justify-self: flex-end;
	}
</style>