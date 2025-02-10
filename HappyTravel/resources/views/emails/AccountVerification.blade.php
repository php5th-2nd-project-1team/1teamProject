<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: 'Apple SD Gothic Neo', 'Malgun Gothic', '맑은 고딕', sans-serif;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .btn-verify {
            display: inline-block;
            padding: 15px 30px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .btn-verify:hover {
            background-color: #2980b9;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>이메일 인증</h2>
        </div>
        
        <div class="content">
            <p>안녕하세요.</p>
            <p>아래 버튼을 클릭하여 계정 확인을 진행해 주세요.</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="btn-verify">
                    계정 확인하기
                </a>
            </div>
            
            <p>인증은 5분 동안 유효합니다.</p>
            <p>본인이 요청하지 않으셨다면, 이 메일을 무시하셔도 됩니다.</p>
        </div>
        
        <div class="footer">
            <p>본 메일은 발신전용이며 회신되지 않습니다.</p>
            <p>© {{ date('Y') }} Pettagon. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 