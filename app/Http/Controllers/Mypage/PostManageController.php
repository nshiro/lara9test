<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostManageController extends Controller
{
    public function index()
    {
        // $posts = Post::get();
        // $posts = Post::where('user_id', auth()->user()->id)->get();
        $posts = auth()->user()->posts;

        return view('mypage.posts.index', compact('posts'));
    }
}
