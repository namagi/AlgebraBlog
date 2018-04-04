@extends('Centaur::layout')

@section('title', 'Console')

@section('content')
    <div class="page-header">
        <h1>Comments</h1>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <form accept-charset="UTF-8" role="form" method="post" action="">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>for post</th>
                        <th>Date</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($comments->count() > 0)
                        @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    {!!
                                        (($comment->status === 0) ? '<span class="label label-danger">Denied</span>' :
                                        (($comment->status === 1) ? '<span class="label label-success">Approved</span>' :
                                                                    '<span class="label label-info">Pending</span>'))
                                    !!}
                                </td>
                                <td>{{ $comment->user->email }}</td>
                                <td>{{ str_limit($comment->content, 60) }}</td>
                                <td>{{ $comment->post->title }}</td>
                                <td title="{{ date('H:i:s', strtotime($comment->created_at)) }}">
                                    {{ date('d.m.Y.', strtotime($comment->created_at)) }}
                                </td>
                                <td>
                                    @if (Sentinel::inRole('administrator'))
                                        <span class="dropdown">
                                            <a class="btn btn-default" data-toggle="dropdown" href="#">
                                                Status
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                @if (($comment->status === 0) || ($comment->status === 2))
                                                    <li>
                                                        {{--<input type="hidden" name="status" value="{{ $comment->status }}">--}}
                                                        <a href="{{ route('status', [$comment->id, 1]) }}">Approve comment</a>
                                                    </li>
                                                @endif
                                                    @if ($comment->status === 1 || $comment->status === 2)
                                                    {{--<li role="separator" class="divider"></li>--}}
                                                    <input type="hidden" name="c{{ $comment->id }}" value="0">
                                                    <li><a href="{{ route('status', [$comment->id, 0]) }}">Deny comment</a></li>
                                                @endif
                                            </ul>
                                        </span>
                                    @endif
                                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-default">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            Edit
                                        </a>
                                        <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger action_confirm"
                                           data-method="delete" data-token="{{ csrf_token() }}">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            Delete
                                        </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">Nemate objavljenih komentara</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="4">{!! $comments->links() !!}</td>
                    </tr>
                    </tbody>
                </table>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@stop
