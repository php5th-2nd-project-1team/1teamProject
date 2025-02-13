<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Inquiry;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use UserToken;

class InquiryController extends Controller
{
	public function getInquiryList()
	{
		$inquiryList = Inquiry::with('users')->orderBy('inquiry_id', 'desc')->paginate(10);

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

	public function deleteInquiry(Request $request, $id)
	{
		$token = $request->bearerToken();

		if(is_null($token)){
			return response()->json([
				'success' => false
				,'msg' => '로그인한 유저만 문의게시글을 삭제할 수 있습니다.'
			], 401);
		}

		UserToken::chkToken($token);

		$user_id = UserToken::getInPayload($token, 'idt');
		$inquiry = Inquiry::find($id);

		try{
			DB::beginTransaction();
			if($inquiry->user_id !== $user_id){
				return response()->json([
					'success' => false
					,'msg' => '본인의 문의게시글만 삭제할 수 있습니다.'
				], 403);
			}
			else if($inquiry->inquiry_response !== null){
				return response()->json([
					'success' => false
					,'msg' => '답변이 달린 문의게시글은 삭제할 수 없습니다.'
				], 403);
			}
			$inquiry->delete();
			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			Log::error($e->getMessage());
			throw new Exception($e->getMessage());
		}

		$responseData = [
			'success' => true
			,'msg' => '문의게시글 삭제 성공'
		];

		return response()->json($responseData, 200);
	}
}
