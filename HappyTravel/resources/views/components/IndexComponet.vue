<template>
    <div class="index-container">
        <!-- 이벤트 -->
        <div class="index-eventbox">
            <div class="index-event-controller">
                <div class="index-event-comment">
                    <p>즐겁게 반려동물과 여행 시작</p>
                </div>
                <h1>여행여행 반려동물과 즐거운 여행👍</h1>
                <p>자세히 보기</p>
                <div class="index-event-buttonArea">
                    <button class="index-event-nextbtn">←</button>
                        <button class="index-event-btn" v-for="value in 5" :key="value"></button>
                    <button class="index-event-nextbtn">→</button>
                </div>
            </div>
            <div class="index-event-viewer">
                <h1>
                    강아지와 첫 여행
                    <br>어떻게 준비하나요?
                </h1>
            </div>
        </div>

        <!-- 코멘트 박스 -->
        <div class="index-commentbox">
            <p>펫브리즈</p>
            <p>반려동물과 함께 여행을 떠나자</p>
            <p>"왈왈 으르렁 컹컹"</p>
        </div>

        <!-- 유튜브 영상 -->
        <div class="index-mediabox">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/4Yd7hXtwhDU?si=HvwyEkjoby6blbKn" title="YouTube video player" frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <p>멍멍냥냥멍멍냥냥멍멍냥냥멍멍냥멍멍냥<br>반려동물과 함께 여행을</p>
            <button>더 알아보기</button>
        </div>

        <!-- 여행지 포스트 -->
        <div class="index-postbox">
            <div class="index-postbox-title">
                <h6>미리보는 여행지</h6>
                <p>#귀여운 반려동물과 즐거운 여행을</p>
            </div>
            <div class="index-category">
                <ul class="">
                    <li>숙소</li>
                    <li>식음료</li>
                    <li>관광지</li>
                    <li>동물병원</li>
                </ul>
                <div class="index-controller">
                    <button><</button>
                    <button>></button>
                </div>
            </div>
            <div class="index-card" v-for="value in 4" :key="value">
                <div class="index-card-img"></div>
                <div class="index-card-content">
                    <p>댕댕냥냥</p>
                </div>
                <div class="index-card-btnArea">
                    <button>→</button>
                </div>
            </div>
        </div>

        <!-- 여행지 상품 -->
        <div class="index-postbox">
            <div class="index-postbox-title">
                <h6>개 끝내주는 상품</h6>
                <p>#원하시는 상품을 찾아보세요</p>
            </div>
            <div class="index-category">
                <ul class="">
                    <li>숙소</li>
                    <li>식음료</li>
                    <li>관광지</li>
                    <li>동물병원</li>
                </ul>
                <div class="index-controller">
                    <button><</button>
                    <button>></button>
                </div>
            </div>
            <div class="index-card" v-for="value in 3" :key="value">
                <div class="index-card-img">
                    <p>sale</p>
                    <p>new</p>
                </div>
                <p>상품이름</p>
                <p class="abc" data-descr="100,000원">200,000원</p>
                <div class="index-card-btnArea">
                </div>
            </div>
        </div>

        <!-- 반려동물 자랑 -->
        <div class="index-postbox">
            <div class="index-postbox-title">
                <h6>커뮤니티 반려동물 자랑</h6>
                <p>#귀여운 댕댕이의 멋진 모습을 자랑해주세요</p>
            </div>
            <div class="index-category-onlyController">
                <div class="index-controller">
                    <button><</button>
                    <button>></button>
                </div>
            </div>
            <div class="index-card" v-for="value in 4" :key="value">
                <div class="index-card-img">
                    <p>sale</p>
                    <p>new</p>
                </div>
                <p>상품이름</p>
                <p>200,000원</p>
                <div class="index-card-btnArea" >
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
    .abc[data-descr]::after{
        content: attr(data-descr);
        text-decoration: line-through;
    }
    .index-container{
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* 이벤트 박스 */
    .index-eventbox{
        width: 80%;
        height: 500px;  
        background: linear-gradient(#D2EEFF, #92D4FF);

        display: grid;
        grid-template-columns: 1fr 2fr;

        border-radius: 80px;

        padding: 0 2rem;
    }

    .index-event-controller{
        display: flex;
        flex-direction: column;
        justify-content: center;

        gap: 10px;

        padding-left: 16px;
    }

    .index-event-comment{
        background-color: black;
        color: white;
        width: 250px;
        height: 32px;
        display: flex;
        justify-content: center;
        align-items: center;

        border-radius: 200px;
        border-bottom-left-radius: 0%;
    }

    .index-event-buttonArea{
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 200px;
    }

    .index-event-nextbtn{
        background-color: white;
        border: 0.05px solid black;
        border-radius: 100%;
        font-size: 0.6rem;
        padding: 5px;
    }

    .index-event-btn{
        background: #ECECEC;
        width: 1.2rem;
        height: 1.2rem;
        border: none;
        border-radius: 100%;
    }

    .index-event-activebtn{
        background-color: #2986FF;
    }
</style>