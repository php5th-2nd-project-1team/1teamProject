@extends('manager.base')

@section('additional_css')
<style>
    .shop-create-header {
        background-color: #f8f9fa;
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .shop-create-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .shop-create-container {
        padding: 0 15px;
    }
    .shop-create-section {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }
    .form-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    .form-input:focus {
        outline: none;
        border-color: #3498db;
    }
    .image-preview {
        max-width: 300px;
        margin-top: 10px;
    }
    .action-buttons {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 2px solid #eee;
        display: flex;
        gap: 15px;
    }
    .btn {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }
    .btn-primary {
        background-color: #3498db;
        color: white;
    }
    .btn-secondary {
        background-color: #95a5a6;
        color: white;
    }
    .btn:hover {
        opacity: 0.9;
    }
    #editor {
        width: 99%;
    }
    .time-inputs {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 15px;
    }
    .time-input {
        width: 150px;
    }
    .date-input {
        width: 200px;
    }
    .input-label {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
<div class="shop-create-header">
    <div class="container-fluid">
        <h1 class="shop-create-title">클래스 등록</h1>
    </div>
</div>

<div class="shop-create-container">
    <div class="shop-create-section">
        <form action="/manager/shops" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">클래스 이름</label>
                <input type="text" name="class_title" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">대표 이미지</label>
                <input type="file" name="class_title_img" class="form-input" accept="image/*" required>
                <img id="imagePreview" class="image-preview" style="display: none;">
            </div>

            <div class="form-group">
                <label class="form-label">클래스 가격</label>
                <input type="number" name="class_price" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">클래스 위치</label>
                <input type="text" name="location" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">시행 일정</label>
                <div class="time-inputs">
                    <div>
                        <div class="input-label">날짜</div>
                        <input type="date" name="class_date" class="form-input date-input" required>
                    </div>
                </div>
                <div class="time-inputs">
                    <div>
                        <div class="input-label">시작 시간</div>
                        <input type="time" name="class_date_time" class="form-input time-input" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">클래스 내용</label>
				<script type="text/javascript" src="/smarteditor3/js/HuskyEZCreator.js" charset="utf-8"></script>
                <textarea id="editor" name="class_content"></textarea>
				<script type="text/javascript">
					var oEditors = [];
					nhn.husky.EZCreator.createInIFrame({
						oAppRef: oEditors,
						elPlaceHolder: "editor",
						sSkinURI: "/smarteditor3/SmartEditor2Skin.html",
						fCreator: "createSEditor2"
					});
				</script>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-primary" onclick="submitForm()">
                    <i class="fas fa-save"></i>
                    등록하기
                </button>
                <a href="/manager/shops" class="btn btn-secondary">
                    <i class="fas fa-list"></i>
                    목록으로
                </a>
            </div>
        </form>
    </div>
</div>
<script>
    @if($errors->any())
        alert('{{ $errors->first() }}');
    @endif
</script>
@endsection

@section('scripts')
<script>
    // 이미지 미리보기
    document.querySelector('input[name="class_image"]').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // 폼 제출하기
    function submitForm(){
        if(confirm('정말 등록하시겠습니까? \n 등록 후 수정은 불가능합니다.')){
            oEditors.getById["editor"].exec("UPDATE_CONTENTS_FIELD", []);
            document.querySelector('#editor').value = getContent();
            document.querySelector('form').submit();
        }
    }

    function getContent(){
		oEditors.getById["editor"].exec("UPDATE_CONTENTS_FIELD", []);
		return document.getElementById("editor").value;
	}
</script>
@endsection
