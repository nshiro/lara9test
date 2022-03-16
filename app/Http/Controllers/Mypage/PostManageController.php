<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostManageController extends Controller
{
    public function index()
    {
        return view('mypage.posts.index');
    }
}
