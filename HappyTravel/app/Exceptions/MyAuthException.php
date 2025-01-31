<?php

namespace App\Exceptions;

use Exception;

class MyAuthException extends Exception
{
    /**
     * 에러 메세지 리스트
     * 
     * @return Array 에러메세지 배열
     *   
     */
    public function context() {
        return [
            'E20' => ['status' => 401, 'msg' => '토큰이 없습니다.']
            ,'E21' => ['status' => 401, 'msg' => '만료된 토큰입니다.']
            ,'E22' => ['status' => 401, 'msg' => '위조된 토큰입니다.']
            ,'E23' => ['status' => 401, 'msg' => '양식에 맞지 않는 토큰입니다.']
            ,'E24' => ['status' => 401, 'msg' => '토큰 정보에 이상이 있습니다.']
            ,'E25' => ['status' => 402, 'msg' => '이미 있는 아이디입니다.']
            ,'E26' => ['status' => 403, 'msg' => 'RefreshToken 만료']
            ,'E27' => ['status' => 403, 'msg' => '이전과 동일한 비밀번호']

            // 매니저 영역
            ,'E30' => ['status' => 401, 'msg' => '계정을 다시 확인 바랍니다.']
            ,'E31' => ['status' => 401, 'msg' => '로그인 상태가 아닙니다.']
        ];
    }
}
