@extends("public.layouts")

@if (!isset($post))
    Not data
@else
    
@section("header_title")
<h1>Post</h1> {{$post->title}}
@endsection

@section("content")
    <img src="/{{ $post->image}}">
    <h2 class="title">{{$post->title }}</h2>
    <time class="date-publisher">{{date("d/m/Y H:i", strtotime($post['created_at']))}}</time>
    <div class="content" style="color: #8c979e; line-height: 2.0">
       <p> {{ $post['content'] }}</p>
    </div>
@endsection

@endif
