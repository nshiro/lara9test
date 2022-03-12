<?php

use App\Http\Controllers\PostListController;
use Illuminate\Support\Facades\Route;

Route::get('', [PostListController::class, 'index']);
