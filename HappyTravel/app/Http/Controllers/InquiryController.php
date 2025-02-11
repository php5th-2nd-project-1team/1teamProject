<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
	public function getInquiryList()
	{
		$inquiryList = Inquiry::paginate(10)->onEachSide(2);

		$responseData = [
			'message' => '문의게시글 목록 조회 성공'
			,'success' => true
			,'data' => $inquiryList
		];

		return response()->json($responseData);
	}
}
