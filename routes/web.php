<?php

use App\Http\Controllers\Mypage\PostManageController;
use App\Http\Controllers\Mypage\UserLoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SignupController;
use App\Http\Middleware\PostShowLimit;
use Illuminate\Support\Facades\Route;

Route::get('', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->whereNumber('post');
    // ->middleware(PostShowLimit::class);

Route::get('signup', [SignupController::class, 'index']);
Route::post('signup', [SignupController::class, 'store']);

Route::get('mypage/login', [UserLoginController::class, 'index'])->name('login');
Route::post('mypage/login', [UserLoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('mypage/logout', [UserLoginController::class, 'logout'])->name('logout');
    Route::get('mypage/posts', [PostManageController::class, 'index'])->name('mypage.posts');
    Route::get('mypage/posts/create', [PostManageController::class, 'create']);
    Route::post('mypage/posts/create', [PostManageController::class, 'store']);
    Route::get('mypage/posts/edit/{post}', [PostManageController::class, 'edit'])->name('mypage.posts.edit');
    Route::post('mypage/posts/edit/{post}', [PostManageController::class, 'update']);
    Route::delete('mypage/posts/delete/{post}', [PostManageController::class, 'destroy'])->name('mypage.posts.delete');
});

