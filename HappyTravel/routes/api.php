<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// assess Token 여부에 따라 

/**
 * 공통 라우트
 */

// 인증이 필요한 라우트 그룹
Route::middleware('my.auth')->group(function() {
    // 인증 관련
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/reissue', [AuthController::class, 'reissue'])->name('auth.reissue');
    Route::post('/mypage/auth/update', [UserController::class, 'UserDetailUpdate'])->name('user.Update');
    Route::post('/mypage/password/update', [UserController::class, 'userPasswordUpdate'])->name('user.password');
    Route::post('/user/withdraw/{id}', [UserController::class, 'UserDestroy'])->name('user.destroy');
    
    Route::post('/user/withdraw', [UserController::class, 'passwordChk'])->name('user.passwordChk');

    // 포스트 댓글 작성(id가 post_id)
    Route::post('/posts/{id}', [PostController::class, 'storePostComment'])->name('store.postComment');
    // 포스트 댓글 삭제(id가 comment_id)
    Route::delete('/posts/{id}', [PostController::class, 'deletePostComment'])->name('destroy.postComment');

    // 포스트 좋아요 클릭
    Route::post('/posts/like/{id}', [PostController::class, 'postLike'])->name('post.like');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * 상기님 Route *
 */
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/registration', [AuthController::class, 'registration'])->name('auth.registration');
Route::post('/userIdCheck', [AuthController::class, 'userIdChk'])->name('auth.IdChk');
Route::get('/user/mypage/{id}', [UserController::class, 'show'])->name('user.show');
Route::post('/passwordcheck', [AuthController::class, 'passwordChk'])->name('auth.passwordcheck');
Route::post('/send-verification-code', [EmailVerificationController::class, 'sendVerificationCode'])->name('user.email');
Route::post('/verify-code', [EmailVerificationController::class, 'verifyCode'])->name('user.verifyCode');
Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider']); // 소셜 로그인 페이지로 리다이렉트
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']); // 콜백 처리
Route::post('/auth/social/Info', [AuthController::class, 'socialInfo']); // 소셜 로그인 후 데이터 받아오는 처리


/**
 * 한결님 Route *
 */
Route::get('/community/notice', [NoticeController::class, 'index'])->name('index.notice');
Route::get('/community/notice/{id}', [NoticeController::class, 'show'])->name('show.notice');
Route::post('/community/notice', [NoticeController::class, 'store'])->name('store.notice');


/**
 * 원상님 Route *
 * 
 */

Route::get('/posts/type', [PostController::class, 'populerPost'])->name('post.type');


/**
 * 민주님 Route *
 */
Route::get('/posts', [PostController::class, 'index'])->name('index.post');
Route::get('/posts/{id}', [PostController::class, 'showPost'])->name('showPost.post');
Route::get('/posts/filter/{id}', [PostController::class, 'postFilter'])->name('showPost.post');


