<?php

namespace App\Http\Controllers;

use App\Models\CommunityBoard;
use Illuminate\Http\Request;

class CommunityBoardController extends Controller
{   
    // 게시글 목록 조회
    public function index() { 
      // $communityBoard = CommunityBoard::with('users')->orderBy('created_at', 'DESC')->paginate(10);
   
      // $responseData = [
      //   'success' =>true
      //   ,'msg' => '게시판 리스트 페이지 획득 성공'
      //   ,'communityBoard' => $communityBoard->toArray()
      // ];
      //  return response()->json($responseData ,200);
      $query = CommunityBoard::with('users')
      ->whereNull('deleted_at') 
      ->orderBy('created_at', 'desc');

      // ✅ 최신 스타일: request() 헬퍼 함수 사용
      if (request()->filled('keyword')) {
      $keyword = request('keyword');
      $type = request('type', 'title_content');

      if ($type === 'title') {
      $query->where('community_title', 'LIKE', "%$keyword%");
      } elseif ($type === 'content') {
      $query->where('community_content', 'LIKE', "%$keyword%");
      } elseif ($type === 'user') {
      $query->whereHas('users', fn ($q) => $q->where('nickname', 'LIKE', "%$keyword%"));
      } elseif ($type === 'title_content') {
      $query->where(fn ($q) => 
          $q->where('community_title', 'LIKE', "%$keyword%")
            ->orWhere('community_content', 'LIKE', "%$keyword%")
      );
      }
      }

      // 10개씩 페이지네이션 적용
      $communityBoard = $query->paginate(10);

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
    
    // 게시물 작성    
    public function store(Request $request) {
        $request->validate([
          'title' => 'required|string|max:50',
          'content' => 'required|string',
          'board_type' => 'required|integer',
        ]);
        $post = CommunityBoard::create([
          'title' => $request->title,
          'content' => $request->content,
          'board_type' => $request->board_type,
      ]);

      return response()->json(['message' => '게시글이 등록되었습니다.', 'post' => $post], 200);
    } 
 }
