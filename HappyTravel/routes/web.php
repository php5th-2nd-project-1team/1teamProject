<?php

use App\Http\Controllers\Managers\ManagerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', function () {
	return view('welcome');
})->where('any', '^(?!manager).*');


// 관리자 사이트
Route::prefix('/manager')->group(function(){
	// 404 페이지 출력
	Route::fallback(function(){
		return view('manager.layout.fallback');
	}); 
	// index (메인페이지 부분) 출력

	// TODO 나중에 컨트롤러를 통해 view를 출력할 것
	// 로그인 페이지 출력
	Route::get('/login', function(){
		return view('manager.layout.login');
	})->name('manager.login');

	Route::post('/login', [ManagerController::class, 'login'])->name('manager.login');

	Route::post('/login', [ManagerController::class, 'login'])->name('manager.login');

	// 댓글 신고관리
	Route::get('/reports/comments', function(){
		return view('manager.layout.report_comments.reportComments');
	})->name('reports.comments');

	// 댓글 신고 상세
	Route::get('/reports/comments/{id}', function(){
		return view('manager.layout.report_comments.reportCommentsDetail');
	})->name('reports.comments.detail');

	// 페이지 신고관리
	Route::get('/reports/pages', function(){
		return view('manager.layout.report_pages.reportPage');
	})->name('reports.pages');

	// 페이지 신고 상세
	Route::get('/reports/pages/{id}', function(){
		return view('manager.layout.report_pages.reportPageDetail');
	})->name('reports.pages.detail');

	Route::middleware('my.manager.auth')->group(function(){
		// 로그아웃 처리
		Route::post('/logout', [ManagerController::class, 'logout'])->name('manager.logout');

		// 메인 페이지 
		Route::get('/', [ManagerController::class, 'index'])->name('manager.index');

		// 유저 영역 =========================================================================
		// 유저 목록 조회
		Route::get('/users', [ManagerController::class, 'users'])->name('user.users');
		// 유저 상세 정보 조회
		Route::get('/users/{id}', [ManagerController::class, 'usersDetail'])->name('user.users.detail');

		// 포스트 관련 =========================================================================
		Route::get('/posts', [ManagerController::class, 'posts'])->name('post.posts'); // 포스트 목록 조회
		
		// 포스트 생성 처리
		Route::get('/posts/create', [ManagerController::class, 'postCreate'])->name('post.posts.create'); // 포스트 작성 폼 출력
		Route::post('/posts', [ManagerController::class, 'postStore'])->name('post.store');
		
		Route::get('/posts/{id}', [ManagerController::class, 'postsDetail'])->name('post.posts.detail'); // 포스트 상세 조회
		
		// 포스트 수정 처리 
		Route::get('/posts/edit/{id}', [ManagerController::class, 'postEdit'])->name('post.posts.edit'); // 포스트 수정 폼 출력
		Route::post('/posts/{id}', [ManagerController::class, 'updatePost'])->name('post.update');

		// 포스트 삭제 처리 
		Route::post('/posts/destroy/{id}', [ManagerController::class, 'postDestroy'])->name('post.destroy');

		// 관리자 로그아웃 처리
		Route::post('/logout', [ManagerController::class, 'logout'])->name('manager.logout');

		// 공지사항 관련 ======================================================================
		Route::get('/notices', [ManagerController::class, 'noticeIndex'])->name('notice.index'); // 공지사항 목록
		Route::get('/notices/create', [ManagerController::class, 'noticeCreate'])->name('notice.create'); // 공지사항 작성
		Route::get('/notices/{id}', [ManagerController::class, 'noticeDetail'])->name('notice.detail'); // 공지사항 상세
		Route::post('/notices', [ManagerController::class, 'noticeStore'])->name('notice.store');		// 공지사항 작성
		Route::get('/notices/edit/{id}', [ManagerController::class, 'noticeEdit'])->name('notice.edit'); // 공지사항 수정 
		Route::post('/notices/{id}', [ManagerController::class, 'noticeUpdate'])->name('notice.update'); // 공지사항 수정
		Route::post('/notices/destroy/{id}', [ManagerController::class, 'noticeDestroy'])->name('notice.destroy'); // 공지사항 삭제

		// 관리자 관련 ================================================================
		Route::get('/managers', [ManagerController::class, 'managerIndex'])->name('manager.index'); // 관리자 목록
		Route::get('/managers/create', [ManagerController::class, 'managerCreate'])->name('manager.create'); // 관리자 작성
		Route::post('/managers', [ManagerController::class, 'managerStore'])->name('manager.store'); // 관리자 작성
	});
});