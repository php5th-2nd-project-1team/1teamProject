<?php

namespace App\Utils;

use App\Exceptions\MyAuthException;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use UserEncrypt;

class UserToken {

    /**
     * 토큰 발급 
     *  
     * @param App/Models/User $user
     * 유저 모델로 유저 전체 데이터 획득
     * 
     * @return Array[$accessToken, $refreshToken]
     * return 토큰 발급 !
     */
    public function createTokens(User $user) {
        $accessToken = $this->createToken($user, env('TOKEN_EXP_ACCESS'));
        $refreshToken = $this->createToken($user, env('TOKEN_EXP_REFRESH'), false);

        return [$accessToken, $refreshToken];
    }

    /**
     * 리프레쉬 토큰 업데이트 (유저에게 재요청이 올 때 accessToken 발급 후 업데이트)
     * 
     * @param App/Models/User $userInfo
     * @param $refreshToken
     * 
     * @return bool true
     */
    public function updateRefreshToken(User $userInfo, $refreshToken) {
        // 유저 모델에 리프레쉬 토큰 변경
        $userInfo->refresh_token = $refreshToken;
        
        if(!($userInfo->save())) {  
            DB::rollBack();
            throw new PDOException('E80');
        }

        return true;
    }

    /**
     * 토큰 유효성 체크
     *
     * @param string $token = bearerToken
     * 
     * @return bool true
     */
    public function chkToken(string|null $token) {
        // 토큰 존재 유무 체크
        // 토큰이 없는 경우, 유효시간이 지난 토큰, 위조된 토큰 등 경우가 많다.
        if(empty($token)) {
            return '토큰이 없음';
        }

        // 토큰 위조 검사
        list($header, $payload, $signature) = $this->explodeToken($token);

        Log::debug('***************************** chkToken start *****************************');
        // 토큰 존재 유무 체크
        // 토큰이 없는 경우, 유효시간이 지난 토큰, 위조된 토큰 등 경우가 많다.
        if(empty($token)) {
            throw new MyAuthException('E20');
        }

        // 토큰 위조 검사
        list($header, $payload, $signature) = $this->explodeToken($token);
        if(UserEncrypt::subSalt($this->createSignature($header, $payload), env('TOKEN_SALT_LENGTH'))
            !== UserEncrypt::subSalt($signature, env('TOKEN_SALT_LENGTH'))) {
            throw new MyAuthException('E22'); 
        }

        // 유효시간 체크
        if($this->getInPayload($token, 'exp') < time()) {
            throw new MyAuthException('E21');
        }

        Log::debug('***************************** chkToken end *******************************');
        return true;
    }

    /**
     * 페이로드에서 해당하는 키의 값을 반혼
     * 페이로드에는 사용자에 데이터가 담아있기 때문에 바꿔놨던 문자열을 다시 돌리는 작업을 진행한다.
     * 
     * @param string $token
     * @param string $key
     * 
     * @return 페이로드에서 추출한 값
     */
    public function getInPayload(string $token, string $key) {
        // 토큰 분리
        list($header, $payload, $signature) = $this->explodeToken($token);

        $decodePayload = json_decode(UserEncrypt::base64UrlDecode($payload));

        // 페이로드에 해당 키의 데이터가 있는지 확인
        if(empty($decodePayload) || !isset($decodePayload->$key)) {
            throw new MyAuthException('E23');
        }

        return $decodePayload->$key;
    }

    //    -----------------------------------------------------------------------------------------------------------------------
    //    private
    //    -----------------------------------------------------------------------------------------------------------------------

    /**
     * JWT 생성하기
     * 
     * @param App/Models/User $user
     * @param int $ttl (Time to Limit)의 약자
     * @param bool $accessFlg = true
     * 
     * @return string JWT   
     */
    private function createToken(User $user, int $ttl, bool $accessFlg = true) {
        $header = $this->createHeader();
        $payload = $this->createPayload($user, $ttl, $accessFlg);
        $signature = $this->createSignature($header, $payload);

        return $header.'.'.$payload.'.'.$signature;
    }

    /**
     * JWT Header
     * 
     * @return string base64UrlEncode
     */
    private function createHeader() {
        $header = [
            // env 파일에 저장한 TOKEN_ALG 저장
            'alg' => env('TOKEN_ALG'),
            // env 파일에 저장한 TOKEN_TYPE 저장
            'typ' => env('TOKEN_TYPE')
        ];

        return UserEncrypt::base64UrlEncode(json_encode($header));
    }

    /**
     * JWT Payload 작성
     * 
     * @param App/Models/User $user
     * @param int $ttl (Time to List)의 약자
     * @param bool $accessFlg = true
     * 
     * @return string base64Payload
     */
    private function createPayload(User $user, int $ttl, bool $accessFlg = true) {
        // 현재 시간 습득 (페이로드 유효 시간 설정하기 위해)
        $now = time();

        // 페이로드 기본 데이터 생성
        $payload = [
            'idt' => $user->user_id,
            'iat' => $now,
            'exp' => $now + $ttl,
            'ttl' => $ttl
        ];

        // 액세스 토큰일 경우 아래 데이터 추가
        if($accessFlg) {

        }

        return UserEncrypt::base64UrlEncode(json_encode($payload));
    }

    /**
     * JWT 시그니처 작성
     *
     * @param string $header base64UrlEncode()
     * @param string $payloade base64UrlEncode()
     *
     * @return string base64Signature
     */
    private function createSignature(string $header, string $payload) {
        return UserEncrypt::hashWithSalt(env('TOKEN_ALG'), $header.env('TOKEN_SECRET_KEY').$payload, UserEncrypt::makeSalt(env('TOKEN_SALT_LENGTH')));
    }

    /**
     * 토큰 분리
     * => 토큰을 분리해서 시그니처 쪽을 암호화를 푼 뒤 payload에 담겨있는 데이터를 가져올 때 사용
     * 
     * @param string $token
     * 
     * @return array $header, $payload, $signature
     */
    private function explodeToken(string $token) {
        $arrToken = explode('.', $token);

        // 토큰 분리 후 오류 체크 (토큰은 헤더 . 페이로드 . 시그니처 총 2개의 점이 있으므로 3개로 나눠져야 함)
        if(count($arrToken) !== 3) {
            throw new MyAuthException('E23');
        }

        return $arrToken;
    }
}