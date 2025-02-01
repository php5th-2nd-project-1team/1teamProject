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
    // 404 페이지 출력
    Route::fallback(function(){
        return view('manager.layout.fallback');
    }); 

    // get 요청 부분
    // index (메인페이지 부분) 출력
    Route::get('/', [ManagerController::class, 'index'])->name('manager.index');

    // TODO 나중에 컨트롤러를 통해 view를 출력할 것
    // 로그인 페이지 출력
    Route::get('/login', function(){
        return view('manager.layout.login');
    })->name('manager.login');

    Route::get('/index', function(){
        return view('manager.layout.index');
    })->name('manager.index');

    Route::get('/users', function(){
        return view('manager.layout.users.users');
    })->name('user.users');

    Route::get('/users/{id}', function(){
        return view('manager.layout.users.usersDetail');
    })->name('user.users.detail');

    Route::get('/posts', function(){
        return view('manager.layout.posts.posts');
    })->name('post.posts');

    Route::get('/posts/create', function(){
        return view('manager.layout.posts.postsCreate');
    })->name('post.posts.create');

    Route::get('/posts/{id}', function(){
        return view('manager.layout.posts.postsDetail');
    })->name('post.posts.detail');

    Route::get('/posts/update/{id}', function(){
        return view('manager.layout.posts.postsUpdate');
    })->name('post.posts.update');

    Route::get('/notices', function(){
        return view('manager.layout.notice.notices');
    })->name('notice.notices');

    Route::get('/notices/create', function(){
        return view('manager.layout.notice.noticesCreate');
    })->name('notice.notices.create');

    Route::get('/notices/{id}', function(){ 
        return view('manager.layout.notice.noticesDetail');
    })->name('notice.notices.detail');

    Route::get('/notices/update/{id}', function(){  
        return view('manager.layout.notice.noticesUpdate');
    })->name('notice.notices.update');

    Route::post('/login', [ManagerController::class, 'login'])->name('manager.login');






    Route::middleware('my.manager.auth')->group(function(){

        // Route::get('/index', function(){
        //     return view('manager.layout.index');
        // })->name('manager.index');

        // 유저 관련

        // 포스트 관련
        Route::post('/posts', [PostController::class, 'storePost'])->name('post.store');
        Route::post('/posts/{id}', [PostController::class, 'updatePost'])->name('post.update');
        Route::post('/posts/delete/{id}', [PostController::class, 'deletePost'])->name('post.delete');

        // 관리자 계정 관련
        Route::post('/logout', [ManagerController::class, 'logout'])->name('manager.logout');
    });
});