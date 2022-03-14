@extends('layouts.index')

@section('content')


<h1>{{ $post->title }}</h1>
<div>{!! nl2br(e($post->body)) !!}</div>

<p>書き手：{{ $post->user->name }}</p>


@endsection