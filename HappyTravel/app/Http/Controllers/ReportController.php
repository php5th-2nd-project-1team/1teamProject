<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use UserToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    // private const REPORT_CATEGORY = [
    //     '01' => '포스트 댓글',
    //     '02' => '커뮤니티 글',
    //     '03' => '커뮤니티 글 댓글',];
    // private const REPORT_CODE = [
    //     '01' => '욕설/비속어 포함',
    //     '02' => '갈등 조장 및 허위사실 유포',
    //     '03' => '폭력적 또는 혐오스러운 컨텐츠',
    //     '04' => '도배 및 광고글',
    //     '05' => '기타'];

    // 신고 작성
    public function report(ReportRequest $request){
        // 토큰있을시에만 작성가능
        // $token = $request->bearerToken();

        // if(!$token) {
        //     return response()->json([
        //         'success' => false
        //         ,'msg' => '로그인 후 신고가 가능합니다.'
        //     ], 400);
        // }
        // $validatedData = $request->validate([
        //     'report_category' => ['required', 'string', function($value, $fail) {
        //         if(!array_key_exists($value, self::REPORT_CATEGORY)) {
        //             $fail('잘못된 신고 카테고리입니다.');
        //         }
        //     }],
        //     'report_code' => ['required', 'string', function($value, $fail) {
        //         if(!array_key_exists($value, self::REPORT_CODE)) {
        //             $fail('잘못된 신고 코드입니다.');
        //         }
        //     }],
        //     'report_board_id' => 'required|biginteger',
        //     'report_text' => 'nullable|string|max:200',
        // ]);

        // $validatedData['user_id'] = UserToken::getInPayload($token, 'idt');

        // $report = Report::create($validatedData);

        // $insertReport = Report::create([
        //     'report_category' => $request->report_category,
        //     'report_board_id' => $request->report_board_id,
        //     'report_code' => $request->report_code,
        //     'report_status' => $request->report_status,
        //     'report_text' => $request->report_text,
        //     'user_id' => auth()->id(),
        // ]);
		$token = $request->bearerToken();
        // 쿠키에 신고쿠키있을시 저장x
        if(isset($_COOKIE['reports'.$request->report_category.$request->report_board_id])){
            return response()->json([
                'msg' => '24시간이내 중복 신고처리'
            ], 422);
        };
        try {
            DB::beginTransaction();
            $data = [];
            $data['report_category'] = $request->report_category;
            $data['report_board_id'] = $request->report_board_id;
            $data['report_code'] = $request->report_code;
            // default 로 migrate에서 설정해놔서 report_status를 데이터로 전달할 필요없다.
            // $data['report_status'] = $request->report_status;
            $data['report_text'] = $request->report_text;
            $data['user_id'] = UserToken::getInPayload($token, 'idt');

            // Log::info('신고 요청 데이터:', $request->all());
            
            // 중복신고 방지(24시간이내 한번만 처리)
            if(!isset($_COOKIE['reports'.$request->report_category.$request->report_board_id])) {
                Report::create($data);
                DB::commit();
                setcookie('reports'.$request->report_category.$request->report_board_id, true, time() + 60 * 60 * 24);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            Log::error('신고 저장 오류: ' . $th->getMessage());
            return response()->json(['message' => '신고 저장 실패'], 500);
        }

        // DB::table('reports')->insert($data);   insert 는 timestamp생성x

        $responseData = [
            'success' => true
            ,'msg' => '신고접수가 완료되었습니다.'
            // ,'insertReport' => $insertReport->toArray()
            ,'data' => $data
        ];
        
        return response()->json($responseData, 200);
    }
}
