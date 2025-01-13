<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailVerification;
use App\Mail\VerificationCodeMail;
use Carbon\Carbon;
use Exception;

class EmailVerificationController extends Controller
{
    // 인증번호 전송
    public function sendVerificationCode(UserRequest $request)
    {
        // 인증번호 생성
        $verificationCode = rand(100000, 999999);

        // 기존 인증번호 기록 삭제 (중복 방지)
        EmailVerification::where('email', $request->email)->delete();

        // DB에 새로운 인증번호 저장
        EmailVerification::create([
            'email' => $request->email,
            'verification_code' => $verificationCode,
            'expires_at' => Carbon::now()->addMinutes(5), // 유효기간 5분
        ]);

        // 인증번호 이메일 전송
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

        return response()->json(['message' => '인증번호가 이메일로 전송되었습니다.']);
    }

    // 인증번호 검증
    public function verifyCode(UserRequest $request)
    {
        // DB에서 인증번호 조회
        $verification = EmailVerification::where('email', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if (!$verification) {
            return response()->json(['message' => '잘못된 인증번호입니다.'], 400);
        }

        // 인증번호 유효기간 확인
        if (Carbon::now()->isAfter($verification->expires_at)) {
            return response()->json(['message' => '인증번호가 만료되었습니다.'], 400);
        }

        // 인증번호가 유효하면 삭제 (보안상 바로 삭제)
        $verification->delete();

        return response()->json(['message' => '이메일 인증 성공']);
    }
}