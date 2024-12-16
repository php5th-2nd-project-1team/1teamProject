<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
	// 포스트 획득
	public function index(Request $request) {
		$local = $request->local;
		$key = $request->search;
		if(!is_null($local)){
			$PostList = Post::where('category_local_num', '=', $local)->orderBy('created_at', 'DESC')->paginate(10);
		} else if(!is_null($key)) {
			$PostList = Post::where(function($query)use($key){
				$query->where('post_title', 'LIKE', '%' . $key . '%')
				->orWhere('post_content', 'LIKE', '%' . $key . '%')
				->orWhere('post_detail_content', 'LIKE', '%' . $key . '%');
			})->orderBy('created_at', 'DESC')->paginate(10);
		} else {
			$PostList = Post::orderBy('created_at', 'DESC')->paginate(10);
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
