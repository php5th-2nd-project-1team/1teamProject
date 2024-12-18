<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Models\User;
use App\Http\Requests\UserRequest;
use UserToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // 로그인 처리
    public function login(UserRequest $request) {
        // 유저 정보 획득
        $userInfo = User::where('account', $request->account)->first();

        Log::debug('로그인 파라미터', $request->all());

        // 탈토된 유저 체크
        if(is_null($userInfo)) {
            throw new AuthenticationException('탈퇴된 회원입니다.');
        }

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
    
    public function logout(Request $request) {
        // 페이로드에서 유저 id 획득
        $id = UserToken::getInPayload($request->bearerToken(), 'idt');

        DB::beginTransaction();
        // 유저 정보 획득
        $userInfo = User::find($id);

        // 리프레쉬 토큰 업데이트
        UserToken::updateRefreshToken($userInfo, null);

        DB::commit();

        $responseData = [
            'success' => true,
            'msg' => '로그아웃 성공',
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

    public function reissue(Request $request) {
        // 페이로드에서 유저 PK 획득
        $userId = UserToken::getInPayload($request->bearerToken(), 'idt');

        // 유저 정보 획득
        $userInfo = User::find($userId); 

        // 리프레쉬 토큰 비교
        if($request->bearerToken() !== $userInfo->refresh_token) {
            throw new MyAuthException('E22');
        }

        // 토큰 발급
        list($accessToken, $refreshToken) = UserToken::createTokens($userInfo);
        
        // 리프레시 토큰 저장
        UserToken::updateRefreshToken($userInfo, $refreshToken);

        $responseData = [
            'success' => true,
            'msg' => '토큰 재발급 성공',
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken
        ];

        return response()->json($responseData, 200);
    }

    public function userIdChk(UserRequest $request) {
        $userId = User::where('account', $request->account)->exists();

        if($userId) {
            throw new MyAuthException('E25');
        }
        
        $responseData = [
            'success' => true,
            'msg' => '사용가능한 아이디입니다.'
        ];

        return response()->json($responseData, 200);
    }

    public function registration(UserRequest $request) {
        $insertData = $request->only('account', 'name', 'gender');
        $insertData['password'] = Hash::make($request->password);
        $insertData['profile'] = '/'.$request->file('file')->store('profile');
        $insertData['nickname'] = $request->nickname;
        $insertData['phone_number'] = $request->phone_number;
        $insertData['address'] = $request->address;
        $insertData['detail_address'] = $request->detail_address;
        $insertData['post_code'] = $request->post_code;

        // insert 처리
        User::create($insertData);

        // response Data 생성
        $responseData = [
            'success' => true,
            'msg' => '성공'
        ];

        return response()->json($responseData, 200);
    }
}
