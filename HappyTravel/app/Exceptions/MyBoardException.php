<?php

namespace App\Exceptions;

use Exception;

class MyBoardException extends Exception
{
    /**
     * 에러 메세지 리스트
     * 
     * @return Array 에러메세지 배열
     *   
     */
    public function context() {
        return [
            
        ];
    }
}
