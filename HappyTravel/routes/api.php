<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

/**
 * 공통 라우트
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * 상기님 Route *
 */
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/user/mypage/{id}', [UserController::class, 'show'])->name('user.show');
Route::post('/passwordcheck', [AuthController::class, 'passwordChk'])->name('auth.passwordcheck');


/**
 * 한결님 Route *
 */
Route::get('/community/notice', [NoticeController::class, 'index'])->name('index.notice');


/**
 * 원상님 Route *
 */


/**
 * 민주님 Route *
 */
Route::get('/posts/{id}', [PostController::class, 'index'])->name('index.post');