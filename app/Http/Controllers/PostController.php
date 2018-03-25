<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Sentinel;
use Exception;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Sentinel::check()) {
            if (Sentinel::inRole('administrator'))
                $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
            else {
                $posts = Post::where('user_id', Sentinel::getUser()->id)->orderBy('created_at', 'DESC')->paginate(10);
            }

            return view('centaur.posts.index',
                [
                    'posts' => $posts,
                ]
            );
        } else {
            session()->flash('warning', 'Need to login first.');
            return redirect()->route('auth.login.form');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('centaur.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Sentinel::getUser()->id;
        $results = $this->validate($request,
                [
                    'title' => 'required|max:191',
                    'content' => 'required',
                ]);

        $data = array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'user_id' => $user_id,
        );

        $post = new Post();
        try {
            $post->savePost($data);
        } catch (Exception $e) {
            session()->flash('danger', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Uspješno ste dodali novi post.');
        return redirect()->route('posts.index');
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
        $post = Post::findOrFail($id);

        return view('centaur.posts.edit',
            [
                'post' => $post,
            ]
        );
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
        $results = $this->validate($request,
                [
                    'title' => 'required|max:191',
                    'content' => 'required',
                ]);

        $data = array(
            'title' => $request->get('title'),
            'content' => $request->get('content')
        );

        $post = Post::findOrFail($id);

        try {
            $post->updatePost($data);
        } catch (Exception $e) {
            session()->flash('danger', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Uspješno ste ažurirali post <strong>"' . $post->title . '</strong>"');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();
        session()->flash('success', 'Uspješno ste izbrisali post zvan <strong>"' . $post->title . '</strong>"');

        return redirect()->back();
    }
}
