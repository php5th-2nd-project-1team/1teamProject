<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\PostComments;
use UserToken;
use Illuminate\Http\Request;

class PostController extends Controller
{
	// 포스트 획득
	public function index(Request $request) {
		$local = $request->local;
		$key = $request->search;
		if(!is_null($local)){
			$PostList = Post::where('category_local_num', '=', $local)->orderBy('created_at', 'DESC')->paginate(1);
		} else if(!is_null($key)) {
			$PostList = Post::where(function($query)use($key){
				$query->where('post_title', 'LIKE', '%' . $key . '%')
				->orWhere('post_content', 'LIKE', '%' . $key . '%')
				->orWhere('post_detail_content', 'LIKE', '%' . $key . '%');
			})->orderBy('created_at', 'DESC')->paginate(1);
		} else {
			$PostList = Post::orderBy('created_at', 'DESC')->paginate(1);
			$PostList = Post::orderBy('created_at', 'DESC')->paginate(1);
		}

		$responseData = [
			'success' => true
			,'msg' => '포스트 획득 성공'
			,'PostList' => $PostList->toArray()
		];

		return response()->json($responseData, 200);
	}

	// 포스트 상세 출력
	public function show(Request $request) {
		$Post = Post::with('manager')->find($request->id);
	}

	public function populerPost(Request $request){
		$type = $request->type;
		$PostList = null;
		if($type === 'view'){
			$PostList = Post::orderBy('post_view', 'DESC')->orderBy('created_at', 'DESC')->paginate(5);
		} else if($type === 'like'){
			$PostList = Post::orderBy('post_like', 'DESC')->orderBy('created_at', 'DESC')->paginate(5);
		} else {
			$PostList = Post::orderBy('created_at', 'DESC')->paginate(5);
		}

		$responseData = [
			'success' => true
			,'msg' => $type.'포스트 획득 성공'
			,'PostList' => $PostList->toArray()
		];

		return response()->json($responseData, 200);
	}

	// 포스트 상세 출력
	// postDetail 도 PostController에 작성 => PostDetailController 은 불필요
	public function showPost(Request $request) {
		$PostDetail = Post::with('manager')->find($request->id);

		$responseData = [
			'success' => true
			,'msg' => '포스트 상세 출력'
			,'PostDetail' => $PostDetail->toArray() 
		];

		return response()->json($responseData, 200);
	}

	// // 포스트 댓글 리스트 출력 (showPost에서 댓글도 같이 가져오기, 따로 뺄 필요없음)
	// public function postCommentList() {
	// 	$postCommentList = PostComments::with('user')->orderBy('created_at', 'DESC')->paginate(5);

	// 	$responseData = [
	// 		'success' => true
	// 		,'msg' => '포스트 댓글 리스트 출력'
	// 		,'postCommentList' => $postCommentList->toArray()
	// 	];

	// 	return response()->json($responseData, 200);
	// }

	
	// 포스트 댓글 작성
	public function storePostComment(StoreCommentRequest $request) {
		// 유효성 체크
		$insertData = $request->only('post_comment');
		$insertData['user_id'] = UserToken::getInPayload($request->bearerToken(), 'idt');
		// post_id 를 받아와야 함 17은 임시
		$insertData['post_id'] = 17;

		// insert
		$storePostComment = PostComments::create($insertData);

		$responseData = [
			'success' => true
			,'msg' => '포스트 댓글 작성 성공'
			,'storePostComment' => $storePostComment->toArray()
		];

		return response()->json($responseData, 200);
	}


	// 게시글 작성
	public function store() {
				
	}

	// 
	public function edit() {

	}

	// 게시글 수정
	public function update() {

	}   

	// 게시글 삭제
	public function destroy() {

	}
}
