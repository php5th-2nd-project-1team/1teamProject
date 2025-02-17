<?php

use App\Http\Controllers\AccountResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityBoardController;
use App\Http\Controllers\CommunityShowoffController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TravelClassController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
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
    
    // 클래스 좋아요 클릭
    Route::post('/shops/like/{id}', [TravelClassController::class, 'classLike'])->name('class.like');

    // iamport 결제 시스템
    Route::post('/payment/request', [TravelClassController::class, 'requestPayment']);
    Route::post('/payment/confirm', [TravelClassController::class, 'confirmPayment']);

    //  신고작성 => 인증 들어가야함
    Route::post('/reports', [ReportController::class, 'report'])->name('report.post');

    // 마이페이지 찜목록(포스트)
    Route::get('/user/wishlist/post', [WishlistController::class, 'postWishlist'])->name('wishlist.post');
    // 마이페이지 찜목록(상품)
    Route::get('/user/wishlist/product', [WishlistController::class, 'productWishlist'])->name('wishlist.product');

    
    Route::post('/community/free/store', [CommunityBoardController::class, 'store'])->name('store.free');
    
    // 자유 댓글 작성(id가 community_id)
    Route::post('/community/free/store/{id}', [CommunityBoardController::class, 'storeFreeComment'])->name('store.freeComment');
    // 자유 댓글 삭제(id가 community_comment_id)
    Route::post('/community/free/destroy/{id}',[CommunityBoardController::class, 'deleteFreeComment'])->name('destroy.freeComment');


    // 문의게시글 작성
    Route::post('/inquiry', [InquiryController::class, 'createInquiry'])->name('inquiry.create');
    // 문의게시글 삭제
    Route::post('/inquiry/destroy/{id}', [InquiryController::class, 'deleteInquiry'])->name('inquiry.delete');
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
Route::get('/shops', [TravelClassController::class, 'shopsBoardList']);
Route::get('/shops/{id}', [TravelClassController::class, 'shopsBoardDetail']);
Route::post('/password-reset/request', [PasswordResetController::class, 'sendResetPasswordEmail'])->name('user.sendResetPasswordEmail'); // 비밀번호 찾기 요청
Route::get('/password-reset/verify', [PasswordResetController::class, 'verifyToken'])->name('user.token'); // 토큰 검증
Route::post('/password-reset/reset', [PasswordResetController::class, 'resetPassword'])->name('user.passwordReset'); // 비밀번호 변경

/**
 * 한결님 Route *
 */
Route::get('/community/notice', [NoticeController::class, 'index'])->name('index.notice');
Route::get('/community/notice/{id}', [NoticeController::class, 'show'])->name('show.notice');
Route::post('/community/notice', [NoticeController::class, 'store'])->name('store.notice');
Route::get('/community/free/{id}', [CommunityBoardController::class , 'show'])->name('show.free');
Route::get('/community/free', [CommunityBoardController::class, 'index'])->name('index.free');
Route::get('/community/showoff', [CommunityShowoffController::class, 'index'])->name('community.showoff.index');

/**
 * 원상님 Route *
 * 
 */

Route::get('/posts/type', [PostController::class, 'populerPost'])->name('post.type');
Route::post('/account-email/request', [AccountResetController::class, 'sendResetAccountEmail'])->name('user.sendResetAccountEmail'); // 아이디 찾기 요청
Route::get('/account-email/request', [AccountResetController::class, 'checkAccountEmail'])->name('user.checkAccountEmail'); // 아이디 찾기 확인

// 문의게시글 조회
Route::get('/inquiry', [InquiryController::class, 'getInquiryList'])->name('inquiry.list');
Route::get('/inquiry/{id}', [InquiryController::class, 'getInquiryDetail'])->name('inquiry.detail');
/**
 * 민주님 Route *
 */
Route::get('/posts', [PostController::class, 'index'])->name('index.post');
Route::get('/posts/{id}', [PostController::class, 'showPost'])->name('showPost.post');
Route::get('/posts/filter/{id}', [PostController::class, 'postFilter'])->name('showPost.post');

// 인덱스 포스트 출력
Route::get('/index', [PostController::class, 'indexPost'])->name('indexPost.post');
// 인덱스 상품 출력
Route::get('/index/shop', [TravelClassController::class, 'indexShop'])->name('indexShop.shop');

Route::get('/index/community', [CommunityBoardController::class, 'indexCommunity'])->name('indexCommunity.community');




