<?php

namespace App\Http\Controllers;

use App\Mail\AccountFindMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountResetController extends Controller
{
    public function sendResetAccountEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required']
            ,'account' => ['required','max:255']
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => '이름과 이메일을 입력해주세요.'], 400);
        } 
        // 기존 요청 삭제 (중복 방지)
        PasswordReset::where('email', $request->email)->delete();

        // 새 토큰 생성 및 저장
        $token = Str::random(64);
        PasswordReset::create([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(5),
        ]);

        // 유저 정보 가져오기
        $user = User::where('email', $request->email)->first();
        $resetUrl = url('/account-recover/result?token='.$token.'&email='.urlencode($request->email));

        // Blade 템플릿 사용한 메일 전송
        Mail::to($request->email)->send(new AccountFindMail($resetUrl));

        return response()->json(['message' => '아이디 확인 이메일이 발송되었습니다.']);
    }

    public function checkAccountEmail(Request $request){
        $token = $request->token;
        $email = $request->email;

        $resetRequest = PasswordReset::where('email', $email)->first();

        if(!$resetRequest || !Hash::check($token, $resetRequest->token)){
            return response()->json(['message' => '유효하지 않은 토큰입니다.'], 400);
        }

        if (now()->gt($resetRequest->expires_at)) {
            return response()->json(['message' => '토큰이 만료되었습니다.'], 400);
        }

        $resetRequest->delete();

        $responseData = [
            'success' => true,
            'message' => '토큰이 유효합니다.',
            'data' => [
                'account' => User::where('email', $email)->first()->account
            ]
        ];

        return response()->json($responseData, 200);
    }
}
