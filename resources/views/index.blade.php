@extends('layouts.index')

@section('content')


<h1>ブログ一覧</h1>

<ul>
    @foreach($posts as $post)
    <li><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>　{{ $post->user->name }}　
        （{{ $post->comments_count }}件のコメント）</li>
    @endforeach
</ul>


@endsection