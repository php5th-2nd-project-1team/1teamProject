<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use PDOException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $th) {
        // 예외 코드 초기화

        // 인스턴스 확인 후 예외 정보 변경
        // instanceof : $th의 인스턴스가 AuthenticationException인지 아닌지 체크하는 문법
        // 첫 번쨰가 내가 검증하고 싶은 객체를 담은 변수, 두 번째는 내가 검증하고 싶은 형태
    
        // report : 우리 시스템이 돌아가다가 에러가 발생하면 에러에 대한 
        // 이력이 남아있어야 고칠 수 있는데, 예외 및 에러기 발생했을 때 호출되며, 주로 로깅이나 외부 서비스에 보고를 하기위한 작업 수행
        Log::info('Report : '.$th->getMessage());
    }

    /**
     * 에러 핸들링 커스텀
     * 예외 및 에러가 브라우저로 렌더링 되기 전에 호출
     * 커스텀 HTTP 응답을 전달
     */

    public function render($request, Throwable $th) {
        // 에외 코드 초기화
        $code = 'E99';

        // 인스턴스 확인 후 예외 정보 변경
        if($th instanceof AuthenticationException) {
            $code = 'E01';
        } else if($th instanceof PDOException) {
            $code = 'E80';
        }   

        $errInfo = $this->context()[$code];

        // 커스텀 Exception 인스턴스 확인
        if($th instanceof MyAuthException) {
            $code = $th->getMessage();
            $errInfo = $th->context()[$code];
        }else if($th instanceof MyBoardException) {
            $code = $th->getMessage();
            $errInfo = $th->context()[$code];
        }

        // Response Data 생성
        $reponseData = [
            'success' => false,
            'code' => $code,
            'msg' => $errInfo['msg'],
        ];

        // response() : response 객체를 생성하는 메소드
        return response()->json($reponseData, $errInfo['status']);
    }

    /**
     * 에러 메세지 리스트 관리
     * 
     * @return Array 에러 메세지 배열 
     */
    // context()라는 함수 안에 에러 메세지들이 자동으로 저장된다.

    public function context() {
        return [
            'E01' => ['status' => 401, 'msg' => '인증 실패'],
            'E50' => ['status' => 400, 'msg' => '잘못된 인증번호입니다.'],
            'E51' => ['status' => 400, 'msg' => '인증번호가 만료되었습니다.'],
            'E80' => ['status' => 500, 'msg' => 'DB 오류가 발생했습니다.'],
            'E99' => ['status' => 500, 'msg' => '시스템 에러가 발생했습니다.'],
        ];
    }
}
