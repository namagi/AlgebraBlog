<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Models\Comment;
use Exception;
use DB;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Sentinel::check()) {
            session()->flash('info', 'Morate se prijaviti.');
            return view('centaur.auth.login');
        } elseif (Sentinel::inRole('administrator')) {
            $comments = Comment::orderBy('user_id', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        } else {
            $comments = Comment::where('user_id', Sentinel::getUser()->id)->orderBy('created_at', 'DESC')->paginate(10);
        }

        return view('console', [
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'comment' => 'required'
            ]);

        $user_id = Sentinel::getUser()->id;
        $data = array(
            'content' => $request->get('comment'),
            'post_id' => $request->get('post_id'),
            'user_id' => $user_id,
            'status'  => 2
        );

        $comment = new Comment();

        try {
            $comment->saveComment($data);
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        session()->flash('success', 'Uspješno ste dodali komentar.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (Sentinel::check()) {
            if (Sentinel::inRole('administrator') || (Sentinel::getUser()->id === $comment->user_id)) {
                return view('comments.edit', ['comment' => $comment]);
            }
        }

        return redirect('/comments');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'content' => 'required',
            ]);

        $data = array(
            'content' => $request->get('content')
        );

        $comment = Comment::findOrFail($id);
        if (Sentinel::getUser()->id === $comment->user_id || Sentinel::inRole('administrator')) {
            try {
                $comment->updateComment($data);
            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
                return redirect()->back();
            }

            session()->flash('success', 'Uspješno ste ažurirali komentar');
            return redirect()->route('comments.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (Sentinel::inRole('administrator') || Sentinel::getUser()->id === $comment->user_id){
            $comment->delete($id);
            session()->flash('success', 'Komentar je obrisan');
        }

        return redirect()->back();
    }

    public function status(Request $request, $comment_id)
    {
        // ->                  -      0      1    2
        // Request->path() = {URL/}comments/id/new_status
        $new_status = explode('/', $request->path())[2];

        define('STATUS',
                [
                    0 => 'blokiran',
                    1 => 'odobren',
                    2 => 'na čekanju'
                ]
            );

        if (Sentinel::check()) {
            if (Sentinel::inRole('administrator')) {
                try {
                    DB::table('comments')->where('id', $comment_id)->update(['status' => $new_status]);
                } catch (Exception $e) {
                    session()->flash('error', $e->getMessage());
                    return redirect('/comments');
                }
            } else {
                session()->flash('error', 'Niste autorizirani');
                return redirect('/comments');
            }
        } else {
            session()->flash('warning', 'Morate se prijaviti');
            return redirect('/login');
        }

        session()->flash('success', 'Komentar je ' . STATUS[$new_status]);
        return redirect()->back();
    }
}
