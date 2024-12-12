<?php

namespace App\Http\Controllers;

use App\Models\Notice;

class NoticeController extends Controller
{
   public function index() {
    $noticeListPage = Notice::with('managers')->orderBy('notice_id', 'DESC')->paginate(10);
    $responseData =[
        'success' => true
        ,'msg' => '공지사항 리스트 페이지 획득 성공'
        ,'notice' => $noticeListPage->toArray(),
    ];
    return response()->json($responseData, 200);
   }
   
}
