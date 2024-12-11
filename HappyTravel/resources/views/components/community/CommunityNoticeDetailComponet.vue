<template>
    <div class="community_notice_detail_container">
        <h1>공지사항</h1> 
    <!-- 공지사항 태그 박스 -->
        <div class="notice_tag_detail_box">
            <div class="notice_tag_detail_number">
                <p>번호</p>
            </div>
            <div class="notice_tag_detail_manager">
                <p>관리자</p>
            </div>
            <div class="notice_tag_detail_date">
                <p>작성일자</p>
            </div>
        </div>
        <div class="notice_detail_title_box">
            <p class="notice_detail_title">제목</p>
            <p class="notice_detail_title_info">"2024년 반려동물 여행 안내"</p>
        </div>   
        <div class="notice_detail_content_box">
            <p class="notice_detail_content">내용</p>
        <textarea disabled cols="30" rows="30">안녕하세요!
        반려동물과 함께하는 여행을 계획하고 계신가요?
        아래의 정보를 참고하여 안전하고 즐거운 여행을 준비해 주세요.

        여행 준비 사항
        반려동물 건강 체크: 여행 전에 반드시 수의사와 상담하여 반려동물의 건강 상태를 확인하세요.
        필수 예방접종: 여행에 필요한 예방접종이 완료되었는지 확인하세요.
        여행용 용품 준비: 반려동물의 음식, 물, 장난감, 침대 등을 준비하세요.

        여행지 선택
        Pet-Friendly 숙소: 반려동물과 함께 머물 수 있는 숙소를 미리 예약하세요.
        여기에서 반려동물 친화적인 숙소를 확인할 수 있습니다.
        여행지 규정 확인방문할 장소의 반려동물 출입 규정을 미리 확인하세요.

        안전한 여행을 위한 팁
        안전벨트 사용: 차량 이동 시 반려동물의 안전을 위해 안전벨트를 착용하세요.
        자주 휴식하기: 장거리 여행 시에는 자주 휴식을 취하여 반려동물이 스트레스를 받지 않도록 하세요.

        반려동물과의 즐거운 여행
        즐거운 활동 계획: 반려동물과 함께 할 수 있는 활동을 미리 계획하세요. 예를 들어, 반려동물과 함께 산책할 수 있는 공원이나 해변을 찾아보세요.
        여행을 떠나기 전, 위의 사항들을 잘 체크하여 안전하고 즐거운 여행이 되시길 바랍니다! 반려동물과 함께하는 특별한 순간을 만끽하세요!

        이 공지는 반려동물과 함께하는 여행을 준비하는 데 도움이 될 것입니다. 안전하고 즐거운 여행이 되길 바랍니다!                        
        </textarea>                 
        </div> 
        <div class="notice_detail_img">
            <img src="/developImg/about-three1.png">
        </div>  
    </div>   
</template>

<script setup>
    
</script>

<style scoped>
      h1 { 
        margin: 20px;
    }
    .community_notice_detail_container {
        margin: 100px;
    }

    /* 공지사항 상세 태그 박스 */
    .notice_tag_detail_box {
        display: grid; 
        grid-template-columns:repeat(3,1fr);
        justify-content: space-around;
        gap:10px;
        border-top : 1px solid black;
        border-bottom : 1px solid black;
        padding: 20px; 
        margin:20px;  
        font-size: 1.5rem;
        font-weight: 300;
        color: #2986FF;
    }
    /* 공지사항 상세 제목 박스 */
    .notice_detail_title_box {
        display: grid;
        grid-template-columns: 40px 1fr;
        margin:20px;
        padding:20px;
        border-bottom : 1px solid black;
        text-align: center;
        line-height: 100px;
    }
    /* 공지사항 상세 제목 */
    .notice_detail_title {    
        font-size: 1.2rem;
        color: #2986FF;
    }
    /* 공지사항 상세 제목 정보 */
    .notice_detail_title_info {
        width: auto;
        min-height: 70px;
        background-color: #EFEFEF;
        border:1px solid #EFEFEF;
        font-size: 1.2rem;
        font-weight: bold;
        
    }
     /* 공지사항 상세 내용 박스 */
    .notice_detail_content_box {
        display: grid;
        grid-template-columns: 40px 1fr;        
        margin:20px;
        padding:20px;        
        border-bottom : 1px solid black;    
       
    }
     /* 공지사항 상세 내용 */
    .notice_detail_content {    
        font-size: 1.2rem;
        color: #2986FF;
    }
    /* 공지사항 상세 내용 롱텍스트 */
    .notice_detail_content_box >textarea {        
             
        background-color: #EFEFEF;
        font-size: 1.2rem;
        font-weight: bold;
        line-height: 2;
        text-align: center;
        resize: none;
        overflow: hidden;
    }
    /* 공지사항 상세 이미지 */
    .notice_detail_img {
        text-align: center;       
    }
</style>