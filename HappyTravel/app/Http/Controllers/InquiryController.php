<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Inquiry;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use UserToken;

class InquiryController extends Controller
{
	public function getInquiryList()
	{
		$inquiryList = Inquiry::orderBy('inquiry_id', 'desc')->paginate(10);

		$responseData = [
			'message' => '문의게시글 목록 조회 성공'
			,'success' => true
			,'data' => $inquiryList
		];

		return response()->json($responseData);
	}

	public function getInquiryDetail($id)
	{
		$inquiryDetail = Inquiry::with('users')->find($id);

		$responseData = [
			'message' => '문의게시글 상세 조회 성공'
			,'success' => true
			,'data' => $inquiryDetail
		];

		return response()->json($responseData);
	}

	public function createInquiry(InquiryRequest $request)
	{
		$token = $request->bearerToken();

		if(is_null($token)){
			return response()->json([
				'success' => false
				,'msg' => '로그인한 유저만 문의게시글을 작성할 수 있습니다.'
			], 401);
		}

		UserToken::chkToken($token);

		$user_id = UserToken::getInPayload($token, 'idt');

		try{
			DB::beginTransaction();

			$inquiry = new Inquiry();
			$inquiry->inquiry_title = $request->inquiry_title;
			$inquiry->inquiry_content = $request->inquiry_content;
			$inquiry->inquiry_secret = $request->inquiry_secret;
			$inquiry->user_id = $user_id;
			$inquiry->save();

			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			Log::error($e->getMessage());
			throw new Exception($e->getMessage());
		}


		$responseData = [
			'success' => true
			,'msg' => '문의게시글 작성 성공'
			,'id' => $inquiry->inquiry_id
		];

		return response()->json($responseData, 200);
	}
}
