<?php

namespace App\Utils;

use App\Models\User;

class UserToken {

    /**
     * 
     *  토큰 발급 
     *  
     *  @param App/Models/User $user
     * 유저 모델로 유저 전체 데이터 획득
     * 
     * @return Array[$accessToken, $refreshToken]
     * return 토큰 발급 !
     */
    
    public function createTokens(User $user) {

    }

    /**
     * 리프레쉬 토큰 업데이트 (유저에게 재요청이 올 때 accessToken 발급 후 업데이트)
     * 
     * @param App/Models/User $user
     * @param $refreshToken
     * 
     * @return bool true
     * 
     */

     public function updateRefreshToken(User $user, $refreshToken) {

     }

     /**
      * 토큰 유효성 체크
      *
      * @param string $token = bearerToken
      * 
      * @return bool true
      */
      public function chkToken(string|null $token) {

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
     * 
     */
}