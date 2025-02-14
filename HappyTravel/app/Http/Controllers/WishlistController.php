<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // 포스트 좋아요
    public function postWishlist(Request $request) {
        $token = $request->bearerToken();
        if(!$token) {
			return response()->json([
				'success' => false
				,'msg' => '로그인한 유저만 볼 수 있습니다.'
			], 400);
		}
		// 유효성 체크
		$insertData = $request->only('post_comment');
		// $insertData['user_id'] = UserToken::getInPayload($token, 'idt');
        
        $postWishlist = User::select('posts.post_title','posts.post_local_name','posts.post_img', 'users.nickname')
                        ->join('post_likes', 'post_likes.user_id', '=', 'users.user_id')
                        ->join('posts', 'posts.post_id', '=', 'post_likes.post_id')
                        // ->where('post_likes.user_id', $token)
                        ->whereNull('posts.deleted_at')
                        ->orderBy('posts.created_at', 'DESC')
                        ->get();

                        $responseData = [
                            'success' => true
                            ,'msg' => '포스트 좋아요 리스트 출력'
                            ,'postWishlist' =>  $postWishlist->toArray()
                        ];

                        return response()->json($responseData, 200);
    }

    
    // 상품 좋아요
    public function productWishlist() {

    }
}
