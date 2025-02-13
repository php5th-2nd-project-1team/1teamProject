@extends('manager.base')

@section('additional_css')
<style>
    .inquiry-detail-header {
        background-color: #f8f9fa;
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .inquiry-detail-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .inquiry-detail-container {
        padding: 0 15px;
    }
    .inquiry-detail-section {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .inquiry-link {
        display: inline-block;
        color: #3498db;
        text-decoration: none;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }
    .inquiry-link:hover {
        text-decoration: underline;
        color: #2980b9;
    }
    .inquiry-link i {
        margin-right: 8px;
    }
    .info-group {
        margin-bottom: 30px;
    }
    .info-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .info-label {
        width: 150px;
        font-weight: 600;
        color: #2c3e50;
    }
    .info-value {
        flex: 1;
        color: #34495e;
    }
    .content-area {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
        line-height: 1.6;
    }
    .answer-section {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }
    .answer-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    .action-buttons {
        margin-top: 20px;
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
        color: white;
    }
    #editor {
        width: 99%;
        min-height: 400px;
    }
</style>
@endsection

@section('content')
<div class="inquiry-detail-header">
    <div class="container-fluid">
        <h1 class="inquiry-detail-title">문의 상세</h1>
    </div>
</div>

<div class="inquiry-detail-container">
    <div class="inquiry-detail-section">
        <a href="{{ $url }}" class="inquiry-link" target="_blank">
            <i class="fas fa-external-link-alt"></i>
            문의게시판으로 이동
        </a>

        <div class="info-group">
            <div class="info-row">
                <div class="info-label">글 제목</div>
                <div class="info-value">{{ $inquiry->inquiry_title }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">작성일자</div>
                <div class="info-value">{{ $inquiry->created_at }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">유저 이름</div>
                <div class="info-value">{{ $inquiry->users->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">문의 내용</div>
                <div class="info-value">
                    <div class="content-area">
                        {!! $inquiry->inquiry_content !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="answer-section">
            <h2 class="answer-title">답변 작성</h2>
            <form action="/manager/inquiries/response/{{ $inquiry->inquiry_id }}" method="POST">
                @csrf
                <input type="hidden" name="page" value="{{ $page }}">
                <script type="text/javascript" src="/smarteditor3/js/HuskyEZCreator.js" charset="utf-8"></script>
                <textarea id="editor" name="inquiry_response"></textarea>
                <script type="text/javascript">
                    var oEditors = [];
                    nhn.husky.EZCreator.createInIFrame({
                        oAppRef: oEditors,
                        elPlaceHolder: "editor",
                        sSkinURI: "/smarteditor3/SmartEditor2Skin.html",
                        fCreator: "createSEditor2",
                        fOnAppLoad: function() {
                            oEditors.getById["editor"].exec("SET_IR", ['{!! $inquiry->inquiry_response !!}']);
                        }
                    });
                </script>

                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="submitForm()">
                        <i class="fas fa-paper-plane"></i>
                        답변 작성
                    </button>
                    <a href="/manager/inquiries" class="btn btn-secondary">
                        <i class="fas fa-list"></i>
                        목록으로
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function submitForm() {
        if(confirm('답변을 작성 또는 수정 하시겠습니까?')){
            oEditors.getById["editor"].exec("UPDATE_CONTENTS_FIELD", []);

            document.querySelector('form').submit();
            return true;
        }
        else{
            return false;
        }
    }
</script>
@endsection
