@extends('manager.base')

@section('additional_css')
<style>
    .notice-create-header {
        background-color: #f8f9fa;
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .notice-create-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .notice-create-container {
        padding: 0 15px;
    }
    .notice-create-section {
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
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
    }
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 1rem;
    }
    .editor-container {
        border-radius: 8px;
        min-height: 400px;
        margin-bottom: 20px;
    }
	#editor{
		width: 99%;
		min-height: 400px;
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
        text-decoration: none;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        color: white;
    }
    .btn-secondary {
        background-color: #95a5a6;
        border-color: #95a5a6;
        color: white;
    }
    .btn:hover {
        opacity: 0.9;
        color: white;
        text-decoration: none;
    }
    .title-container {
        margin-bottom: 25px;
    }
    .title-input-group {
        position: relative;
    }
    .title-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .important-check {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .important-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
    .important-check label {
        color: #e74c3c;
        font-weight: 600;
        cursor: pointer;
        margin: 0;
    }
    .form-control {
        flex: 1;
    }
</style>
@endsection

@section('content')
<div class="notice-create-header">
    <div class="container-fluid">
        <h1 class="notice-create-title">공지사항 작성</h1>
    </div>
</div>

<div class="notice-create-container">
    <div class="notice-create-section">
        <form id="noticeForm" method="POST" action="/manager/notices" onsubmit="return handleSubmit(event)">
            @csrf
            <div class="form-group">
                <div class="title-container">
                    <div class="title-input-group">
                        <label class="form-label">제목</label>
                        <div class="title-checkbox-wrapper">
                            <input type="text" class="form-control" name="notice_title" placeholder="제목을 입력하세요" required>
                            <div class="important-check">
                                <input type="checkbox" id="notice_tag" name="notice_tag" value="1">
                                <label for="notice_tag">중요</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">내용</label>
                <div id="smartEditor" class="editor-container">
                    <script type="text/javascript" src="/smarteditor3/js/HuskyEZCreator.js"></script>
					<textarea id="editor"></textarea>
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
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-primary" >
                    <i class="fas fa-save"></i>
                    저장
                </button>
                <a href="/manager/notices" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    취소
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleSubmit(event) {
        event.preventDefault();
        
        // TODO: 에디터 내용 가져오기 및 폼 제출 처리
        if(confirm('공지사항을 등록하시겠습니까? ')) {
            const content = document.querySelector('#editor');
            content.value = getContent();
            content.name = 'notice_content';

            document.getElementById('noticeForm').submit();
        }
        

        return false;
    }

	// 내용 출력 부분
	function getContent(){
		oEditors.getById["editor"].exec("UPDATE_CONTENTS_FIELD", []);

		return document.getElementById("editor").value;
	}

    @if($errors->any())
        <script>
            alert('{{ $errors->first() }}');
        </script>
    @endif
</script>

@endsection
