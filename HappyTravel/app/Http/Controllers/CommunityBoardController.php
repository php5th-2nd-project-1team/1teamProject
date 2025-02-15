<?php

namespace App\Http\Controllers;

use App\Models\CommunityBoard;
use App\Models\CommunityComment;
use Exception;
use Illuminate\Support\Facades\DB;
use UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommunityBoardController extends Controller
{   
    // 게시글 목록 조회
    public function index() { 
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
            'success' => true,
            'msg' => '게시판 리스트 페이지 획득 성공',
            'communityBoard' => $communityBoard->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 특정 게시물 조회
    public function show(Request $request, $id) {
        $token = $request->bearerToken();
        $token = $token === 'null' ? null : $token;
        $CommunityComment = null;

        $communityBoardDetail = CommunityBoard::with('users')->find($id);
        $CommunityComment = CommunityComment::with('users')
            ->where('community_id', '=', $request->id)
            ->orderBy('created_at', 'DESC')->get();

        $CommuntiyCommentCnt = CommunityComment::select('community_id', CommunityComment::raw('COUNT(comment_content) cnt'))
            ->where('community_id', '=', $request->id)
            ->groupBy('community_id')
            ->first();

        $responseData = [
            'success' => true,
            'msg' => '자유게시판 상세리스트 정보가 맞습니다.',
            'communityBoardDetail' => $communityBoardDetail->toArray(),
            'CommunityComment' => $CommunityComment->toArray(),
            'CommuntiyCommentCnt' => $CommuntiyCommentCnt !== null ? $CommuntiyCommentCnt->toArray() : ["community_id" => $request->id, "cnt" => 0]
        ];

        return response()->json($responseData, 200);
    }
	
    // 게시물 작성    
    public function store(Request $request) {
        $insertData = $request->only('user_id');
        $insertData['community_type'] = $request->community_type;
        $insertData['community_title'] = $request->title;
        $insertData['community_content'] = $request->content;
        
        $community = CommunityBoard::create($insertData);

        $responseData = [
            'success' => true,
            'showBoard' => $community->toArray(),
            'msg' => '성공'
        ];

        return response()->json($responseData, 200);
    } 

    // 실제로 댓글 페이지네이션시 CommunityComment 만 쓰면 얘만 쓰는 함수를 따로 빼야함
    public function getComment(Request $request) {
        $CommunityComment = null;
        $CommunityComment = CommunityComment::with('users')
            ->where('community_id', '=', $request->id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        $responseData = [
            'success' => true,
            'msg' => '커뮤니티  코멘트 출력',
            'CommunityComment' => $CommunityComment->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 커뮤니티 댓글 작성
    public function storeFreeComment(Request $request, $id) {
        $token = $request->bearerToken();

        if(!$token) {
            return response()->json([
                'success' => false,
                'msg' => '로그인한 유저만 댓글을 작성할 수 있습니다.'
            ], 400);
        }

        $validator = Validator::make($request->only('comment_content'), [
            'comment_content' => ['required', 'string', 'max:300'],
        ]);

		if($validator->fails()) {
			return response()->json([
				'success' => false,
				'msg' => '댓글 내용을 입력해주세요.'
			], 400);
		}

		$user_id = UserToken::getInPayload($token, 'idt');
		$content = $request->comment_content;

		$responseData = [];
		try{
			DB::beginTransaction();
				$comment = new CommunityComment();
				$comment->user_id = $user_id;
				$comment->community_id = $id;
				$comment->comment_content = $content;
				$comment->save();
				$responseData = [
					'success' => true,
					'msg' => '커뮤니티 댓글 작성 성공',
					'storeFreeComment' => $comment->toArray()
				];
			DB::commit();
		}catch(Exception $e) {
			DB::rollBack();
			$responseData = [
				'success' => false,
				'msg' => '댓글 작성 실패',
				'error' => $e->getMessage()
			];
		}

        return response()->json($responseData, 200);
    } 

    // 커뮤니티 자유게시판 댓글 삭제
    public function deleteFreeComment($id) {
        DB::beginTransaction();
        CommunityComment::destroy($id);
        DB::commit();

        $responseData = [
            'success' => true,
            'msg' => '커뮤니 코멘트 삭제'
        ];
        return response()->json($responseData, 200);
    }

    public function indexCommunity() {
        $indexCommunity = CommunityBoard::select('community_photos.community_photo_url', 'community_photos.community_id', 'community_boards.community_title', 'users.nickname')
            ->join('community_photos', 'community_photos.community_id', '=', 'community_boards.community_id')
            ->join('users', 'community_boards.user_id', '=', 'users.user_id')
            ->whereNull('community_boards.deleted_at')
            ->orderBy('community_boards.created_at', 'desc')
            ->limit(4)
            ->get();

        $responseData = [
            'success' => true,
            'msg' => '인덱스 커뮤니티 리스트 획득 성공',
            'indexCommunity' => $indexCommunity->toArray()
        ];
                        
        return response()->json($responseData, 200);
    }
}
