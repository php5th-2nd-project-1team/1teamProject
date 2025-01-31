<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
	public function index(){
		return view('manager.index');
	}

	public function login(Request $request){

		$validator = Validator::make($request->only('m_account', 'm_password'), [
			'm_account' => ['required'],
			'm_password' => ['required']
		]);

		if($validator->fails()){
			return response()->json(['message' => '유효성 검사 실패']);
		}

		$manager = Manager::where('m_account', $request->m_account)->first();

		if(!$manager){
			return response()->json(['message' => '아이디 없음']);
			// throw new MyAuthException('E30');
		}

		if(!Hash::check($request->m_password, $manager->m_password)){
			return response()->json(['message' => '비밀번호 틀림']);
			// throw new MyAuthException('E30');
		}

		Auth::guard('manager')->login($manager);

		return response()->json(['message' => '로그인 성공']);
	}

	public function logout(){
		Auth::guard('manager')->logout();
		return response()->json(['message' => '로그아웃 성공']);
	}
}
