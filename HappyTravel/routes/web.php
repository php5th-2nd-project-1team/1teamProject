<?php

use App\Http\Controllers\ManagerController;
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
    Route::get('/', [ManagerController::class, 'index'])->name('manager.index');

    Route::post('/login', [ManagerController::class, 'login'])->name('manager.login');

    Route::middleware('my.manager.auth')->group(function(){
        // 유저 관련
        Route::get('/users', [UserController::class, 'users'])->name('user.users');

        // 포스트 관련
        Route::post('/posts', [PostController::class, 'storePost'])->name('post.store');
        Route::post('/posts/{id}', [PostController::class, 'updatePost'])->name('post.update');
        Route::post('/posts/delete/{id}', [PostController::class, 'deletePost'])->name('post.delete');

        // 관리자 계정 관련
        Route::post('/logout', [ManagerController::class, 'logout'])->name('manager.logout');
    });
});