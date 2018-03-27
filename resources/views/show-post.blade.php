@extends('Centaur::layout')

@section('title')
{{ $post->title }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>{{ $post->title }}</h1>
        <time>{{ $post->created_at }}</time>
        <hr>
        <div>
            {{ $post->content }}
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h4>Comments:</h4>
    </div>
</div>
<hr>
@if (Sentinel::check())
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="col-md-8 col-md-offset-2">
            <a href="#" class="btn btn-primary btn-sm">Comment</a>
        </div>
    </div>
</div>
@endif
@stop
