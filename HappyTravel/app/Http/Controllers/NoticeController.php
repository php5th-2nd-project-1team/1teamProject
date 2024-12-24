<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
   public function index() {
        $noticeListPageNomal = Notice::with('managers')->where('notice_tag', 0)->orderBy('created_at', 'DESC')->paginate(10);
        $noticeListPageimportant = Notice::with('managers')->where('notice_tag', 1)->orderBy('created_at', 'DESC')->limit(5)->get();

        $responseData =[
            'success' => true
            ,'msg' => '공지사항 리스트 페이지 획득 성공'
            ,'noticeListPageNomal' => $noticeListPageNomal->toArray()
            ,'noticeListPageimportant' => $noticeListPageimportant->toArray()
        ];
        
        return response()->json($responseData, 200);
   }
   
   public function show($id) {
        $noticeDetail = Notice::with('managers')->find($id);        
      
        $responseData = [
            'success' => true
            ,'msg' => '공지사항 상세리스트 정보가 맞습니다.'
            ,'noticeDetail'=> $noticeDetail->toArray(),
        ];
        return response()->json($responseData, 200);
   }
}
