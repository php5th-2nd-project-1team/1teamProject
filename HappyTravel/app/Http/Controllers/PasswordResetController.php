<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function sendResetPasswordEmail(UserRequest $request)
{
    // 기존 요청 삭제 (중복 방지)
    PasswordReset::where('email', $request->email)->delete();

    // 새 토큰 생성 및 저장
    $token = Str::random(64);
    PasswordReset::create([
        'email' => $request->email,
        'token' => Hash::make($token),
        'created_at' => now(),
        'expires_at' => now()->addMinutes(30),
    ]);

    // 유저 정보 가져오기
    $user = User::where('email', $request->email)->first();
    $resetUrl = url('/password-reset?token=' . $token . '&email=' . urlencode($request->email));

    // Blade 템플릿 사용한 메일 전송
    Mail::to($request->email)->send(new ResetPasswordMail($user->name, $resetUrl));

    return response()->json(['message' => '비밀번호 변경 이메일이 발송되었습니다.']);
}

public function verifyToken(UserRequest $request)
    {
        $resetRequest = PasswordReset::where('email', $request->email)->first();

        if (!$resetRequest || !Hash::check($request->token, $resetRequest->token)) {
            return response()->json(['message' => '유효하지 않은 토큰입니다.'], 400);
        }

        if (now()->gt($resetRequest->expires_at)) {
            return response()->json(['message' => '토큰이 만료되었습니다.'], 400);
        }

        return response()->json(['message' => '토큰이 유효합니다.'], 200);
    }

    public function resetPassword(UserRequest $request)
    {
        // 2️⃣ 비밀번호 재설정 요청 조회
        $resetRequest = PasswordReset::where('email', $request->email)->first();
    
         // 4️⃣ 유저 조회 및 비밀번호 변경
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['message' => '사용자를 찾을 수 없습니다.'], 404);
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        // 5️⃣ 사용된 토큰 삭제
        $resetRequest->delete();
    
        return response()->json(['message' => '비밀번호가 변경되었습니다.'], 200);
    }
}
