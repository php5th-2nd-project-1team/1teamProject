<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id) {
        $user = User::find($id);

        $responseData = [
            'success' => true,
            'msg' => '유저 정보 획득 성공',
            'user' => $user->toArray()
        ];

     return response()->json($responseData, 200);
    }
}
