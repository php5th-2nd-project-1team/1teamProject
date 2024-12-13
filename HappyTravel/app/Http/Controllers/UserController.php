<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id) {
        // 유저 마이페이지 정보 획득
        $user = User::find($id);

        // 보내줄 데이터 담기
        $responseData = [
            'success' => true,
            'msg' => '유저 정보 획득 성공',
            'user' => $user->toArray()
        ];

     return response()->json($responseData, 200);
    }
}
