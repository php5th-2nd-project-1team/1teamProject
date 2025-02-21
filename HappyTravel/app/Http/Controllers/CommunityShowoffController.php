<?php

namespace App\Http\Controllers;

use App\Models\CommunityBoard;
use App\Models\CommunityComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityShowoffController extends Controller
{
    public function index() {
        $communityShowoff = CommunityBoard::with(['communityPhotos', 'users'])->where('community_type' ,'=', '1')->paginate(4);

        $responseData = [
            'success' => true
            ,'msg' => '자랑게시판 리스트 획득 성공'
            ,'communityShowoff'=> $communityShowoff->toArray()
        ];

       return response()->json($responseData ,200);
    }

    // ------------------ meerkat Edit Start ------------------
    public function showOffDetail($id) {
        $communityBoardDetail = CommunityBoard::with(['communityPhotos', 'users'])->find($id);
        $CommunityComment = CommunityComment::with('users')
            ->where('community_id', '=', $id)
            ->orderBy('created_at', 'DESC')->get();

        $CommuntiyCommentCnt = CommunityComment::select('community_id', CommunityComment::raw('COUNT(comment_content) cnt'))
            ->where('community_id', '=', $id)
            ->groupBy('community_id')
            ->first();

        	// 조회수 쿠키없으면 쿠키에 저장
		if(!isset($_COOKIE['community_views'.$id])){
			DB::beginTransaction();
			// 조회수 추가
			$communityBoardDetail->community_view += 1;
			$communityBoardDetail->save();
			DB::commit();

			setcookie('community_views'.$id , true, time() + 60 * 60 * 24);
		}
        $responseData = [
            'success' => true,
            'msg' => '자유게시판 상세리스트 정보가 맞습니다.',
            'communityShowoff' => $communityBoardDetail->toArray(),
            'CommunityComment' => $CommunityComment->toArray(),
            'CommuntiyCommentCnt' => $CommuntiyCommentCnt !== null ? $CommuntiyCommentCnt->toArray() : ["community_id" => $id, "cnt" => 0]
        ];

        return response()->json($responseData, 200);
    }
    // ------------------ meerkat Edit End ------------------
}
