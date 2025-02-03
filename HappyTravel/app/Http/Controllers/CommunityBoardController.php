<?php

namespace App\Http\Controllers;

use App\Models\CommunityBoard;
use Illuminate\Http\Request;

class CommunityBoardController extends Controller
{   
    // 게시글 목록 조회
    public function index() { 
      
      $communityBoard = CommunityBoard::orderBy('created_at', 'desc')->get();

      $responseData = [
        'success' =>true
        ,'msg' => '게시판 리스트 페이지 획득 성공'
        ,'communityBoard' => $communityBoard->toArray()
      ];
       return response()->json($responseData ,200);
    }

    // 특정 게시물 조회
    public function show($id) {
        $communityBoardDetail = CommunityBoard::with('users')->find($id);

    }
}
