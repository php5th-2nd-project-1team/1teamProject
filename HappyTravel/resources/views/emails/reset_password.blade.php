<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 재설정</title>
</head>
<body>
    <div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd;">
        <h2 style="color: #2986FF;">비밀번호 재설정 요청</h2>
        <p>안녕하세요, {{ $name }}님.</p>
        <p>비밀번호를 재설정하려면 아래 버튼을 클릭하세요.</p>
        <p>
            <a href="{{ $resetUrl }}" 
               style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #2986FF; text-decoration: none; border-radius: 5px;">
                비밀번호 재설정하기
            </a>
        </p>
        <p>위 버튼이 작동하지 않으면 아래 링크를 복사해서 브라우저에 붙여넣어 주세요.</p>
        <p>{{ $resetUrl }}</p>
        <p>감사합니다.</p>
    </div>
</body>
</html>