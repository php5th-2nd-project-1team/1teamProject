<?php

namespace App\Utils;

use Illuminate\Support\Str;

class UserEncrypt {
    /**
     * base64 URL 인코드
     * 
     * @param string $json
     * 
     * @return string base64UrlIncode
     * 
     */
    public function base64UrlEncode(string $json) {
        return rtrim(strtr(base64_encode($json), '+/', '-_'), '=');
    }

    /**
     * 
     */
    public function base64UrlDecode(string $base64) {
        return base64_decode(strtr($base64, '=_', '+/'));
    }



    /**
     * slat(솔트) 특정 길이만큼 랜덤한 문자열 생성
     * 
     * @param int $saltLength
     * 
     * @return string 랜덤 문자열
     */
    public function makeSalt($length) {
        return Str::random($length);
    }

    /**
     * 문자열 암호화 (토큰 암호화)
     * 
     * @param string $alg => 알고리즘 명
     * @param string $str => 암호화 할 문자열
     * @param string $salt => 솔트
     * 
     * @return string 암호화 완료된 문자열 (토큰)
     */
    public function hashWithSalt(string $alg, string $str, string $salt) {
        return hash($alg, $str).$salt;
    }

    /**
     * 특정 길이의 솔트를 제거한 문자열을 반환
     * 
     * @param string $signature 솔트가 포함된 시그니처
     * @param int $saltLength 솔트 길이
     * 
     * @return string 솔트 제거한 문자열
     */
    public function subSalt(string $signature, int $saltLength) {
        return mb_substr($signature, 0, (-1 * $saltLength));
    }
}