@extends('Centaur::layout')

@section('title')
    Edit comment
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit comment</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form" method="post" action="{{ route('comments.update', $comment->id) }}">
                        <fieldset>
                            <div class="form-group">
                                <label for="email">Author:</label>
                                <input disabled="disabled" class="form-control" placeholder="Email" name="email" type="text" value="{{ $comment->user->email }}" />
                            </div>
                            <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
                                <label for="content">Comment:</label>
                                <textarea class="form-control" placeholder="Comment content" name="content" rows="10">{{ $comment->content }}</textarea>
                                {!! ($errors->has('content') ? $errors->first('content', '<p class="text-danger">:message</p>') : '') !!}
                            </div>

                            <input name="_token" value="{{ csrf_token() }}" type="hidden">
                            {{ method_field('PUT') }}
                            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
