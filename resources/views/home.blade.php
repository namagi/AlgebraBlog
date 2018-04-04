@extends('Centaur::layout')

@section('title', 'Posts')

@section('content')

@if ($posts->count() > 0)
<div class="row">
    @foreach ($posts as $post)
        <div class="col-md-4">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title text-center" style="font-weight:700;">
                        {{ $post->title }}
                    </h3>
                </div>

                <div class="panel-body">
                    {{ str_limit($post->content, 160) }}
                </div>

                <div class="panel-footer">
                    <a href="{{ route('post.show', $post->slug) }}" class="btn btn-primary btn-xs">Read more...</a>
                    <span style="float:right; font-style:italic;">{{ $post->commentsCountFormatted() }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-md-12">
        {{ $posts->links() }}
    </div>
</div>
@else
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-info text-center">Trenutno nema postova.</h2>
    </div>
</div>
@endif
@stop
