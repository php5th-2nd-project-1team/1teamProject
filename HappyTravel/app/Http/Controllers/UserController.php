<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    public function UserDetailUpdate(Request $request) {

        $user = User::find($request->user_id);

        // update 할 데이터 담기
        $profile = '/'.$request->file('file')->store('profile');
        $updateData = $request->only('nickname', 'name', 'phone_number', 'address', 'detail_address');
        $user->nickname = $request->nickname;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->detail_address = $request->detail_address;
        $user->profile = $profile;

        // update 처리
        $result = $user->save($updateData);

        $responseData = [
            'success' => true,
            'msg' => '성공',
            'userInfo' => $user->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function UserDestroy($id) {

        $user = User::find($id);

        $user->delete();

        $responseData = [
            'success' => true,
            'msg' => '회원탈퇴 성공'
        ];

        return response()->json($responseData, 200);
    }

    public function passwordChk(Request $request) {

        // 유저 정보 획득
        $userInfo = User::where('user_id', $request->user_id)->first();

        // 비밀번호 체크
        if(!(Hash::check($request->password, $userInfo->password))) {
            throw new AuthenticationException('비밀번호 체크 오류');
        }   
 
        $responseData = [
            'success' => true,
            'msg' => '비밀번호 확인 성공',
            'data' => $userInfo->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
