<template>   
    <div class="mypage-container">
        <div class="mypage-border">
            <div class="mypage-title">
                <h1>마이페이지</h1>
                <button class="mypage-back-btn">홈으로</button>
            </div>
            <hr class="title-hr">
            <div class="mypage-main">
                <div class="mypage-profile">
                    <div class="profile"></div>
                    <br>
                    <div class="mypage-nickname">
                        <span class="mypage-all-title">닉네임</span>
                        <p class="mypage-nickname-border">뿡뿡이1</p>
                    </div>
                </div>
                <div class="mypage-detail">
                    <div class="mypage-name">
                        <span class="mypage-all-title">성함</span>
                        <p class="mypage-name-border">홍길동</p>
                    </div>

                    <div class="mypage-number">
                        <p class="mypage-all-title">전화번호</p>
                        <p class="mypage-number-border">010-1111-1111</p>
                    </div>

                    <div class="mypage-adress">
                        <span class="mypage-all-title">주소</span>
                        <p class="mypage-adress-border">대구</p>
                    </div>
                    
                    <div class="mypage-adress-detail">
                        <span class="mypage-all-title">상세주소</span>
                        <p class="mypage-adress-detail-border">대구아파트</p>
                    </div>
                </div>
            </div>
            <hr class="footer-hr">
            <div class="footer-title">
                <button class="mypage-user-update-btn">회원정보 수정</button>
            </div>
        </div>
    </div>


    <router-view></router-view>
</template>
<script setup>

</script>
<style scoped>
button {
    cursor: pointer;
}

.mypage-container {
    width: 100%;
    height: 600px;

    
    display: flex;
    justify-content: center;
    align-items: center;
}

.mypage-border {
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    width: 60%;
    height: 80%;
}

    
.mypage-title {
    display: flex;
    justify-content: space-between;
    padding: 15px;
}

.mypage-back-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 20px;
    width: 125px;
    height: 45px;
    margin-top: 5px;
}

.mypage-back-btn:hover {
    background-color: white;
    border: 3px solid #2986FF;
    color: black;
}

.mypage-main {
    display: grid;
    grid-template-columns: 0.3fr 0.7fr;
}

.title-hr {
   width: 100%;
   margin-bottom: 40px;
}

.mypage-all-title {
    font-size: 10px;
    font-weight: 900;
}

.mypage-nickname {
    width: 50%;
}

.mypage-nickname-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
}

.mypage-profile {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.profile {
    background-image: url('../../../../public/developImg/about-three1.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    width: 150px;
    height: 150px;
    border: 1px solid black;
    border-radius: 50%;
}

.mypage-update-btn {
    background-color: #EFEFEF;
    border: none;
    border-radius: 10px;
    width: 50px;
    height: 30px;
    margin-right: 20px;
}

.mypage-delete-btn {
    background-color: #EFEFEF;
    border: none;
    border-radius: 10px;
    width: 50px;
    height: 30px;
}

.mypage-name-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 20%;
}

.mypage-number-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 30%;
}

.mypage-adress-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 80%;
}

.mypage-adress-detail-border {
    background-color: #EFEFEF;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
    width: 80%;
}

.footer-hr {
    width: 100%;
    margin-top: 40px;
    margin-bottom: 20px;
}

.mypage-user-update-btn {
    background-color: #2986FF;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 17px;
    width: 125px;
    height: 45px;
    margin-left: 15px;
}

.mypage-user-update-btn:hover {
    background-color: white;
    border: 3px solid #2986FF;
    color: black;
}

</style>