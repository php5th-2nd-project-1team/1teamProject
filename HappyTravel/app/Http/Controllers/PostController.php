<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 포스트 획득
    public function index() {
        $PostList = Post::orderBy('created_at', 'DESC')->pagination(12);

        $responseData = [
            'success' => true
            ,'msg' => '포스트 획득 성공'
            ,'PostList' => $PostList->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 포스트 상세 출력
    public function show($id) {
        $Post = Post::with()->find($id);
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
