@extends('manager.base')

@section('additional_css')
<style>
	.post-detail-header {
		background-color: #f8f9fa;
		padding: 25px 0;
		margin-bottom: 30px;
		border-bottom: 1px solid #dee2e6;
		box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	}
	.post-detail-title {
		font-size: 2rem;
		font-weight: bold;
		color: #2c3e50;
		margin: 0;
		display: flex;
		align-items: center;
		gap: 15px;
	}
	.post-detail-container {
		padding: 0 15px;
	}
	.post-detail-section {
		background-color: white;
		padding: 40px;
		border-radius: 12px;
		box-shadow: 0 2px 15px rgba(0,0,0,0.1);
		margin-bottom: 30px;
	}
	.section-title {
		font-size: 1.2rem;
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 20px;
		padding-bottom: 10px;
		border-bottom: 2px solid #eee;
	}
	.checkbox-group, .radio-group {
		display: flex;
		flex-wrap: wrap;
		gap: 15px;
		margin-bottom: 25px;
	}
	.checkbox-item, .radio-item {
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.form-group {
		margin-bottom: 25px;
	}
	.form-label {
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 8px;
	}
	.image-preview {
		max-width: 600px;
		width: 100%;
		border-radius: 8px;
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		margin-top: 10px;
	}
	.sub-images {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
		gap: 20px;
		margin-top: 15px;
	}
	.sub-images .image-preview {
		max-width: 100%;
		height: auto;
	}
	.detail-info {
		background-color: #f8f9fa;
		padding: 20px;
		border-radius: 8px;
		margin-top: 10px;
	}
	.detail-row {
		display: flex;
		margin-bottom: 15px;
		gap: 30px;
	}
	.detail-label {
		min-width: 120px;
		font-weight: 600;
		color: #2c3e50;
	}
	.detail-value {
		color: #495057;
	}
	.coordinates {
		display: flex;
		gap: 20px;
	}
	.theme-select {
		width: 200px;
		padding: 8px;
		border-radius: 4px;
		border: 1px solid #ced4da;
	}
	.content-area {
		min-height: 150px;
		margin-bottom: 20px;
	}
	.text-content-group {
		background-color: #f8f9fa;
		border-radius: 8px;
		padding: 15px;
		margin-bottom: 25px;
		border-left: 4px solid #3498db;
	}
	
	.text-content-group .form-label {
		color: #2c3e50;
		font-size: 0.9rem;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin-bottom: 10px;
	}
	
	.text-content-group .detail-value {
		color: #2c3e50;
		font-size: 1.1rem;
		line-height: 1.6;
		padding: 10px;
		background-color: white;
		border-radius: 4px;
		box-shadow: 0 1px 3px rgba(0,0,0,0.05);
	}
	
	.content-area {
		min-height: 100px;
		white-space: pre-line;
		padding: 15px;
		background-color: white;
		border-radius: 4px;
		box-shadow: 0 1px 3px rgba(0,0,0,0.05);
	}
	
	.post-link {
		display: inline-block;
		color: #3498db;
		text-decoration: none;
		margin-bottom: 20px;
		font-size: 1.1rem;
	}
	.post-link:hover {
		text-decoration: underline;
	}
	.post-link i {
		margin-left: 5px;
	}
	
	.status-select {
		width: 200px;
		padding: 8px;
		border-radius: 4px;
		border: 1px solid #ced4da;
		margin-bottom: 25px;
		background-color: #f8f9fa;
	}
	
	.action-buttons {
		margin-top: 40px;
		padding-top: 20px;
		border-top: 1px solid #dee2e6;
		display: flex;
		gap: 15px;
	}
	
	.btn {
		padding: 10px 25px;
		border-radius: 8px;
		font-weight: 500;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	
	.btn-primary {
		background-color: #3498db;
		border-color: #3498db;
		color: white;
	}
	
	.btn-secondary {
		background-color: #6c757d;
		border-color: #6c757d;
		color: white;
	}
	
	.btn-danger {
		background-color: #e74c3c;
		border-color: #e74c3c;
		color: white;
	}
</style>
@endsection

@section('content')
<div class="post-detail-header">
	<div class="container-fluid">
		<h1 class="post-detail-title">포스트 상세 정보</h1>
	</div>
</div>

<div class="post-detail-container">
	<div class="post-detail-section">
		<a href="/posts/{{ $post->category_theme_num }}/{{ $post->post_id }}" target="_blank" class="post-link">
			사이트에서 보기 <i class="fas fa-external-link-alt"></i>
		</a>

		<div class="text-content-group">
			<div class="form-label">포스트 제목</div>
			<div class="detail-value">{{ $post->post_title }}</div>
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
			@foreach ($animalTypes as $animalType)
				@php
					$checked = false;
					foreach($postAnimalTypes as $postAnimalType){
						if($animalType->animal_type_num === $postAnimalType->animal_type_num){
							$checked = true;
						}
					}
				@endphp
				<label class="checkbox-item">
					<input type="checkbox" {{ $checked ? 'checked' : '' }} value="{{ $animalType->animal_type_num }}" disabled> {{ $animalType->animal_type_name }}
				</label>
			@endforeach
		</div>

		<div class="section-title">시설 기능</div>
		<div class="checkbox-group">
			@foreach ($facilities as $facility)
				@php
					$checked = false;
					foreach($postFacilities as $postFacility){
						if($facility->facility_type_num === $postFacility->facility_type_num){
							$checked = true;
						}
					}
				@endphp
				<label class="checkbox-item">
					<input type="checkbox" {{ $checked ? 'checked' : '' }} value="{{ $facility->facility_type_num }}" disabled> {{ $facility->facility_type_name }}
				</label>
			@endforeach
		</div>

		<div class="form-group">
			<div class="form-label">테마</div>
			<select class="theme-select" disabled>
				@foreach($categoryTheme as $theme)
					@if($theme->category_theme_num === $post->category_theme_num)
						<option selected>{{ $theme->category_theme_name }}</option>
					@else
						<option>{{ $theme->category_theme_name }}</option>
					@endif
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<div class="form-label">지역</div>
			<select class="theme-select" disabled>
				@foreach($categoryLocal as $local)
					@if($local->category_local_num === $post->category_local_num)
						<option selected>{{ $local->category_local_name }}</option>
					@else
						<option>{{ $local->category_local_name }}</option>
					@endif
				@endforeach
			</select>
		</div>

		<div class="text-content-group">
			<div class="form-label">지역 상세</div>
			<div class="detail-value">{{ $post->post_local_name }}</div>
		</div>

		<div class="text-content-group">
			<div class="form-label">내용 요약</div>
			<div class="detail-value content-area">
				{{ $post->post_content}}
			</div>
		</div>

		<div class="text-content-group">
			<div class="form-label">내용</div>
			<div class="detail-value content-area">
				{{ $post->post_detail_content }}
			</div>
		</div>

		<div class="image-section">
			<div class="form-label">대표 이미지</div>
			<img src="{{ $post->post_img }}" alt="대표 이미지" class="image-preview">
		</div>

		<div class="image-section">
			<div class="form-label">상세 이미지</div>
			<div class="sub-images">
				<img src="{{ $post->post_subimg1 }}" alt="상세 이미지 1" class="image-preview">
				<img src="{{ $post->post_subimg2 }}" alt="상세 이미지 2" class="image-preview">
				<img src="{{ $post->post_subimg3 }}" alt="상세 이미지 3" class="image-preview">
			</div>
		</div>

		<div class="section-title">상세 정보</div>
		<div class="detail-info">
			<div class="detail-row">
				<div class="detail-label">주소</div>
				<div class="detail-value">
					{{ $post->post_detail_addr }}
					<div class="coordinates">
						<span>{{ $post->post_lat }}</span>
						<span>{{ $post->post_lon }}</span>
					</div>
				</div>
			</div>

			<div class="detail-row">
				<div class="detail-label">전화번호</div>
				<div class="detail-value">{{ $post->post_detail_num }}</div>
			</div>

			<div class="detail-row">
				<div class="detail-label">홈페이지</div>
				<div class="detail-value">{{ $post->post_detail_site }}</div>
			</div>

			<div class="detail-row">
				<div class="detail-label">이용시간</div>
				<div class="detail-value">{{ $post->post_detail_time }}</div>
			</div>

			<div class="detail-row">
				<div class="detail-label">요금</div>
				<div class="detail-value">{{ $post->post_detail_price }}</div>
			</div>

			<div class="detail-row">
				<div class="detail-label">주차가능여부</div>
				<div class="radio-group">
                    <label class="radio-item">
                        <input type="radio" name="parking" value="available" {{ $post->post_detail_parking === '0' ? 'checked' : '' }} disabled> 가능
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="parking" value="unavailable" {{ $post->post_detail_parking === '1' ? 'checked' : '' }} disabled> 불가능
                    </label>
				</div>
			</div>
		</div>

		<div class="action-buttons">
			<button type="button" class="btn btn-primary" onclick="handleEdit()">
				<i class="fas fa-edit"></i>
				포스트 수정
			</button>
			<button type="button" class="btn btn-secondary" onclick="location.href='/manager/posts?page={{ $page }}'">
				<i class="fas fa-list"></i>
				목록으로
			</button>
			<form action="/manager/posts/destroy/{{ $post->post_id }}" method="POST" style="display: inline;">
				@csrf
				<button type="submit" class="btn btn-danger" onclick="return confirm('정말로 이 게시물을 삭제하시겠습니까?');">삭제</button>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	function handleEdit() {
		if(confirm('포스트를 수정하시겠습니까?')) {
			location.href = '/manager/posts/edit/{{ $post->post_id }}';
		}
	}
</script>
@endsection