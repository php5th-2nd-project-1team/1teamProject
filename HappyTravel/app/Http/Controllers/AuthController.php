<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use UserToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // 로그인 처리
    public function login(UserRequest $request) {
        // 유저 정보 획득
        $userInfo = User::where('account', $request->account)->first();

        Log::debug('로그인 파라미터', $request->all());

        // 비밀번호 체크
        if(!(Hash::check($request->password, $userInfo->password))) {
            throw new AuthenticationException('비밀번호 체크 오류');
        }   

        // 토큰 발행
        list($accessToken, $refreshToken) = UserToken::createTokens($userInfo);

        // 리프레쉬 토큰 저장
        UserToken::updateRefreshToken($userInfo, $refreshToken);
 
        $responseData = [
            'success' => true,
            'msg' => '로그인 성공',
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
            'data' => $userInfo->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function passwordChk(UserRequest $request) {

        $userInfo = User::where('account', $request->account)->first();

        Log::debug('로그인 파라미터', $request->all());

        if(!(Hash::check($request->password, $userInfo->password))) {
            throw new AuthenticationException('비밀번호 체크 오류');
        }   

        $responseData = [
            'success' => true,
            'msg' => '비밀번호 체크 성공',
            'data' => $userInfo->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
