@extends('manager.base')

@section('additional_css')
<style>
    // ... postsDetail의 기존 스타일 유지 ...

    /* 주소 검색 관련 스타일 추가 */
    .address-search-btn {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 15px;
    }
    .address-search-btn:hover {
        background-color: #2980b9;
    }
    
    /* 모달 스타일 */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
    }
    .modal-content {
        position: relative;
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.2);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    .modal-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
    }
    .close-modal {
        font-size: 1.5rem;
        color: #666;
        cursor: pointer;
        border: none;
        background: none;
    }
    .search-input-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .search-input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    .search-results {
        max-height: 300px;
        overflow-y: auto;
    }
    .search-result-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }
    .search-result-item:hover {
        background-color: #f8f9fa;
    }
    
    /* 입력 필드 스타일 */
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    textarea.form-control {
        min-height: 150px;
    }
</style>
@endsection

@section('content')
<div class="post-detail-header">
    <div class="container-fluid">
        <h1 class="post-detail-title">포스트 작성</h1>
    </div>
</div>

<div class="post-detail-container">
    <div class="post-detail-section">
        <div class="text-content-group">
            <div class="form-label">포스트 제목</div>
            <input type="text" class="form-control" placeholder="제목을 입력하세요">
        </div>

        <div class="form-group">
            <div class="form-label">포스트 개시 상태</div>
            <select class="status-select">
                <option>개시 중</option>
                <option>개시 중단</option>
                <option>수정 중</option>
            </select>
        </div>

        <div class="section-title">입장 가능한 동물 종류</div>
        <div class="checkbox-group">
            <label class="checkbox-item">
                <input type="checkbox" name="animal_types[]" value="small_dog"> 소형견
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="animal_types[]" value="medium_dog"> 중형견
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="animal_types[]" value="large_dog"> 대형견
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="animal_types[]" value="cat"> 고양이
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="animal_types[]" value="bird"> 조류
            </label>
        </div>

        <div class="section-title">시설 기능</div>
        <div class="checkbox-group">
            <label class="checkbox-item">
                <input type="checkbox" name="facilities[]" value="pet_menu"> 펫메뉴
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="facilities[]" value="pet_cafe"> 펫카페
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="facilities[]" value="pet_hotel"> 펫호텔
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="facilities[]" value="pet_fitness"> 펫피트니스
            </label>
            <label class="checkbox-item">
                <input type="checkbox" name="facilities[]" value="pet_beauty"> 펫미용
            </label>
        </div>

        <div class="form-group">
            <div class="form-label">테마</div>
            <select class="theme-select">
                <option value="cafe">카페</option>
                <option value="accommodation">숙소</option>
                <option value="hospital">병원</option>
                <option value="tourist">여행지</option>
            </select>
        </div>

        <div class="form-group">
            <div class="form-label">지역</div>
            <select class="theme-select" name="region">
                <option value="seoul">서울</option>
                <option value="gyeonggi">경기</option>
                <option value="gyeongbuk">경북</option>
                <option value="gyeongnam">경남</option>
            </select>
        </div>

        <div class="text-content-group">
            <div class="form-label">지역 상세</div>
            <input type="text" class="form-control" placeholder="지역 상세 정보를 입력하세요">
        </div>

        <div class="text-content-group">
            <div class="form-label">내용 요약</div>
            <textarea class="form-control" placeholder="내용 요약을 입력하세요"></textarea>
        </div>

        <div class="text-content-group">
            <div class="form-label">내용</div>
            <textarea class="form-control" placeholder="상세 내용을 입력하세요"></textarea>
        </div>

        <div class="image-section">
            <div class="form-label">대표 이미지</div>
            <input type="file" class="form-control" name="main_image" accept="image/*">
            <img id="mainImagePreview" class="image-preview" style="display: none;">
        </div>

        <div class="image-section">
            <div class="form-label">상세 이미지 1</div>
            <input type="file" class="form-control" name="detail_image_1" accept="image/*">
            <img id="detailImagePreview1" class="image-preview" style="display: none;">
        </div>

        <div class="image-section">
            <div class="form-label">상세 이미지 2</div>
            <input type="file" class="form-control" name="detail_image_2" accept="image/*">
            <img id="detailImagePreview2" class="image-preview" style="display: none;">
        </div>

        <div class="image-section">
            <div class="form-label">상세 이미지 3</div>
            <input type="file" class="form-control" name="detail_image_3" accept="image/*">
            <img id="detailImagePreview3" class="image-preview" style="display: none;">
        </div>

        <div class="section-title">상세 정보</div>
        <div class="detail-info">
            <button type="button" class="address-search-btn" onclick="openAddressModal()">
                <i class="fas fa-search"></i> 주소 검색
            </button>
            
            <div class="detail-row">
                <div class="detail-label">주소</div>
                <div class="detail-value">
                    <input type="text" class="form-control" id="address" placeholder="주소">
                    <div class="coordinates">
                        <input type="text" class="form-control" id="latitude" placeholder="위도">
                        <input type="text" class="form-control" id="longitude" placeholder="경도">
                    </div>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">전화번호</div>
                <div class="detail-value">
                    <input type="tel" class="form-control" placeholder="전화번호를 입력하세요">
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">홈페이지</div>
                <div class="detail-value">
                    <input type="url" class="form-control" placeholder="홈페이지 URL을 입력하세요">
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">이용시간</div>
                <div class="detail-value">
                    <input type="text" class="form-control" placeholder="이용시간을 입력하세요">
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">요금</div>
                <div class="detail-value">
                    <input type="text" class="form-control" placeholder="요금을 입력하세요">
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">주차가능여부</div>
                <div class="radio-group">
                    <label class="radio-item">
                        <input type="radio" name="parking" value="available"> 가능
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="parking" value="unavailable"> 불가능
                    </label>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                포스트 저장
            </button>
            <button type="button" class="btn btn-danger" onclick="history.back()">
                <i class="fas fa-times"></i>
                취소
            </button>
        </div>
    </div>
</div>

<!-- 주소 검색 모달 -->
<div id="addressModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">주소 검색</h3>
            <button class="close-modal" onclick="closeAddressModal()">&times;</button>
        </div>
        <div class="search-input-group">
            <input type="text" class="search-input" id="searchInput" placeholder="지역명을 입력하세요">
            <button class="address-search-btn" onclick="searchAddress()">검색</button>
        </div>
        <div class="search-results" id="searchResults">
            <!-- 검색 결과가 여기에 동적으로 추가됨 -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openAddressModal() {
        document.getElementById('addressModal').style.display = 'block';
    }
    
    function closeAddressModal() {
        document.getElementById('addressModal').style.display = 'none';
    }
    
    function searchAddress() {
        const searchInput = document.getElementById('searchInput').value;
        const resultsContainer = document.getElementById('searchResults');
        
        // 예시 데이터 - 실제로는 API 호출 필요
        const mockResults = [
            '서울특별시 강남구 테헤란로 123',
            '서울특별시 강남구 역삼동 456',
            '서울특별시 서초구 서초동 789'
        ];
        
        resultsContainer.innerHTML = mockResults.map(address => `
            <div class="search-result-item" onclick="selectAddress('${address}')">
                ${address}
            </div>
        `).join('');
    }
    
    function selectAddress(address) {
        document.getElementById('address').value = address;
        // 예시 좌표값
        document.getElementById('latitude').value = '37.12345';
        document.getElementById('longitude').value = '127.12345';
        closeAddressModal();
    }
    
    // 모달 외부 클릭 시 닫기
    window.onclick = function(event) {
        const modal = document.getElementById('addressModal');
        if (event.target == modal) {
            closeAddressModal();
        }
    }

    // 이미지 프리뷰 기능 추가
    function handleImagePreview(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 이미지 입력 필드에 변경 이벤트 리스너 추가
    document.querySelector('input[name="main_image"]').addEventListener('change', function() {
        handleImagePreview(this, 'mainImagePreview');
    });
    document.querySelector('input[name="detail_image_1"]').addEventListener('change', function() {
        handleImagePreview(this, 'detailImagePreview1');
    });
    document.querySelector('input[name="detail_image_2"]').addEventListener('change', function() {
        handleImagePreview(this, 'detailImagePreview2');
    });
    document.querySelector('input[name="detail_image_3"]').addEventListener('change', function() {
        handleImagePreview(this, 'detailImagePreview3');
    });
</script>
@endsection
