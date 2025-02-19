@extends('manager.base')

@section('additional_css')
<style>
    // ... postsCreate.blade.php의 스타일 그대로 가져오기 ...

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

    /* 좌표 입력 필드 스타일 수정 */
    .coordinate-group {
        flex: 1;
    }

    .coordinate-label {
        font-size: 0.9rem;
        color: #495057;
        margin-bottom: 5px;
        font-weight: 500;
    }

    /* 좌표 입력 필드 스타일 */
    .coordinates {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    .coordinates input {
        flex: 1;
    }

    /* 현재 이미지 표시 영역 스타일 */
    .current-image {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
    }
    .image-preview {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin-top: 10px;
    }
    .text-muted {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .mb-2 {
        margin-bottom: 0.5rem;
    }
    .mt-3 {
        margin-top: 1rem;
    }

    /* textarea 관련 스타일 수정 */
    textarea.form-control {
        min-height: 150px;
        resize: none;  /* 크기 조절 비활성화 */
    }

    /* 상세 내용은 더 큰 높이로 설정 */
    textarea.form-control.detail-content {
        min-height: 300px;
    }
</style>
@endsection

@section('content')
<div class="post-detail-header">
    <div class="container-fluid">
        <h1 class="post-detail-title">포스트 수정</h1>
    </div>
</div>

<form action="/manager/posts/{{ $post->post_id }}" method="POST" enctype="multipart/form-data" onsubmit="submitPost()">
    @csrf
    <div class="post-detail-container">
        <div class="post-detail-section">
            <div class="text-content-group">
                <div class="form-label">포스트 제목</div>
                <input type="text" name="post_title" class="form-control" placeholder="제목을 입력하세요" value="{{ $post->post_title }}" required>
            </div>

            <div class="form-group">
                <div class="form-label">포스트 개시 상태</div>
                <select class="status-select" disabled>
                    <option selected>개시 중</option>
                    <option>개시 중단</option>
                    <option>수정 중</option>
                </select>
            </div>

            <div class="section-title">입장 가능한 동물 종류</div>
            <div class="checkbox-group">
                @foreach($animalTypes as $animal)
                    <label class="checkbox-item">
                        <input type="checkbox" name="animal_type_num[]" value="{{ $animal->animal_type_num }}"
                            {{ $postAnimalTypes->contains('animal_type_num', $animal->animal_type_num) ? 'checked' : '' }}>
                        {{ $animal->animal_type_name }}
                    </label>
                @endforeach
            </div>

            <div class="section-title">시설 기능</div>
            <div class="checkbox-group">
                @foreach($facilityTypes as $facility)
                    <label class="checkbox-item">
                        <input type="checkbox" name="facility_type_num[]" value="{{ $facility->facility_type_num }}"
                            {{ $postFacilities->contains('facility_type_num', $facility->facility_type_num) ? 'checked' : '' }}>
                        {{ $facility->facility_type_name }}
                    </label>
                @endforeach
            </div>

            <div class="form-group">
                <div class="form-label">테마</div>
                <select class="theme-select" name="category_theme_num">
                    @foreach($categoryThemes as $theme)
                        <option value="{{ $theme->category_theme_num }}"
                            {{ $post->category_theme_num == $theme->category_theme_num ? 'selected' : '' }}>
                            {{ $theme->category_theme_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <div class="form-label">지역</div>
                <select class="theme-select" name="category_local_num">
                    @foreach($categoryLocals as $local)
                        <option value="{{ $local->category_local_num }}" 
                            {{ $post->category_local_num == $local->category_local_num ? 'selected' : '' }}>
                            {{ $local->category_local_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-content-group">
                <div class="form-label">지역 상세</div>
                <input type="text" name="post_local_name" class="form-control" placeholder="지역 상세 정보를 입력하세요" value="{{ $post->post_local_name }}">
            </div>

            <div class="text-content-group">
                <div class="form-label">내용 요약</div>
                <textarea name="post_content" class="form-control" placeholder="내용 요약을 입력하세요" required>{{ $post->post_content }}</textarea>
            </div>

            <div class="text-content-group">
                <div class="form-label">내용</div>
                <textarea name="post_detail_content" class="form-control detail-content" placeholder="상세 내용을 입력하세요" required>{{ $post->post_detail_content }}</textarea>
            </div>

            <div class="image-section">
                <div class="form-label">대표 이미지</div>
                <div class="current-image">
                    <span class="text-muted">현재 이미지:</span>
                    <img src="{{ $post->post_img }}" class="image-preview mb-2">
                </div>
                <input type="file" class="form-control" name="post_img" accept="image/*">
                <img id="mainImagePreview" class="image-preview" style="display: none;">
            </div>

            <div class="image-section">
                <div class="form-label">상세 이미지 1</div>
                <div class="current-image">
                    <span class="text-muted">현재 이미지:</span>
                    <img src="{{ $post->post_subimg1 }}" class="image-preview mb-2">
                </div>
                <input type="file" class="form-control" name="post_subimg1" accept="image/*">
                <img id="detailImagePreview1" class="image-preview" style="display: none;">
            </div>

            <div class="image-section">
                <div class="form-label">상세 이미지 2</div>
                <div class="current-image">
                    <span class="text-muted">현재 이미지:</span>
                    <img src="{{ $post->post_subimg2 }}" class="image-preview mb-2">
                </div>
                <input type="file" class="form-control" name="post_subimg2" accept="image/*">
                <img id="detailImagePreview2" class="image-preview" style="display: none;">
            </div>

            <div class="image-section">
                <div class="form-label">상세 이미지 3</div>
                <div class="current-image">
                    <span class="text-muted">현재 이미지:</span>
                    <img src="{{ $post->post_subimg3 }}" class="image-preview mb-2">
                </div>
                <input type="file" class="form-control" name="post_subimg3" accept="image/*">
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
                        <input type="text" class="form-control" id="address" name="post_detail_addr" placeholder="주소" value="{{ $post->post_detail_addr }}" required readonly>
                        <div class="coordinates">
                            <div class="coordinate-group">
                                <div class="coordinate-label">위도</div>
                                <input type="text" class="form-control" id="latitude" name="post_lat" placeholder="위도" value="{{ $post->post_lat }}" required readonly>
                            </div>
                            <div class="coordinate-group">
                                <div class="coordinate-label">경도</div>
                                <input type="text" class="form-control" id="longitude" name="post_lon" placeholder="경도" value="{{ $post->post_lon }}" required readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">전화번호</div>
                    <div class="detail-value">
                        <input type="text" name="post_detail_num" class="form-control" placeholder="전화번호를 입력하세요" value="{{ $post->post_detail_num }}">
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">홈페이지</div>
                    <div class="detail-value">
                        <input type="url" name="post_detail_site" class="form-control" placeholder="홈페이지 URL을 입력하세요" value="{{ $post->post_detail_site }}">
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">이용시간</div>
                    <div class="detail-value">
                        <input type="text" name="post_detail_time" class="form-control" placeholder="이용시간을 입력하세요" value="{{ $post->post_detail_time }}">
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">요금</div>
                    <div class="detail-value">
                        <input type="text" name="post_detail_price" class="form-control" placeholder="요금을 입력하세요" value="{{ $post->post_detail_price }}">
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">주차가능여부</div>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="post_detail_parking" value="0" {{ $post->post_detail_parking === '0' ? 'checked' : '' }} required> 가능
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="post_detail_parking" value="1" {{ $post->post_detail_parking === '1' ? 'checked' : '' }} required> 불가능
                        </label>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    수정사항 저장
                </button>
                <button type="button" class="btn btn-danger" onclick="history.back()">
                    <i class="fas fa-times"></i>
                    취소
                </button>
            </div>
        </div>
    </div>
</form>

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

    function submitPost(e){
        e.preventDefault();

        if(confirm('포스트를 수정하시겠습니까?')){
            e.target.submit();
        }

        return false;
    }
    
    function searchAddress() {
        const searchInput = document.getElementById('searchInput').value;
        const resultsContainer = document.getElementById('searchResults');
        
        const config = {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'KakaoAK 7c1eb7d4363ccb73a7c0e9eabb46fc72'
            }
        }

        const url = 'https://dapi.kakao.com/v2/local/search/keyword.json?query=' + searchInput;

        axios.get(url, config)
        .then(response => {
            const results = response.data.documents.map(item => ({
                name: item.place_name,
                address: item.address_name,
                lat: item.y,
                lon: item.x
            }));

            resultsContainer.innerHTML = results.map(result => `
                <div class="search-result-item" onclick="selectAddress('${result.address}', ${result.lat}, ${result.lon})">
                    <div style="font-weight: bold; color: #2c3e50; margin-bottom: 4px;">${result.name}</div>
                    <div style="color: #666; font-size: 0.9em;">${result.address}</div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error(error);
            resultsContainer.innerHTML = '<div class="p-3 text-danger">검색 중 오류가 발생했습니다.</div>';
        });
    }
    
    function selectAddress(address, lat, lon) {
        document.getElementById('address').value = address;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
        closeAddressModal();
    }
    
    // 모달 외부 클릭 시 닫기
    window.onclick = function(event) {
        const modal = document.getElementById('addressModal');
        if (event.target == modal) {
            closeAddressModal();
        }
    }

    // 이미지 프리뷰 기능
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
    document.querySelector('input[name="post_img"]').addEventListener('change', function() {
        handleImagePreview(this, 'mainImagePreview');
    });
    document.querySelector('input[name="post_subimg1"]').addEventListener('change', function() {
        handleImagePreview(this, 'detailImagePreview1');
    });
    document.querySelector('input[name="post_subimg2"]').addEventListener('change', function() {
        handleImagePreview(this, 'detailImagePreview2');
    });
    document.querySelector('input[name="post_subimg3"]').addEventListener('change', function() {
        handleImagePreview(this, 'detailImagePreview3');
    });
</script>
@endsection
