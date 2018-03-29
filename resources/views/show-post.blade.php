@extends('Centaur::layout')

@section('title')
{{ $post->title }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>{{ $post->title }}</h1>
        <time>{{ \Carbon\Carbon::createFromTimestamp(strtotime($post->created_at))->diffForHumans() }}</time>
        <hr>
        <div style="border: 1px solid #ddd; padding: 1em 1.75em;">
            {{ $post->content }}
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h4>Comments:</h4>
        @if ($post->comments->count() > 0)
                @foreach ($post->comments as $comment)
                    <div class="container-fluid">
                        <h3>{{ $comment->user->email }}</h3>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach
        @else
            <div class="container-fluid">
                Trenutno nema komentara
            </div>
        @endif
    </div>
</div>
<!--<hr>-->
@if (Sentinel::check())
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="post" action="{{ route('comments.store') }}">
            <div class="form-group">
                <label>Post comment:</label>
                <textarea name="comment" class="form-control" rows="5"></textarea>
                {!! ($errors->has('comment') ? $errors->first('comment', '<p class="text-danger">:message</p>') : '') !!}
            </div>

            {{ csrf_field() }}
            <input type="hidden" name="post_id" value="{{ $post->id }}"
            <div class="form-group">
                <button type="submit" class="btn btn-default" style="float:right;margin-bottom:5em">Post comment</button>
            </div>

        </form>
    </div>
</div>
@endif
@stop
