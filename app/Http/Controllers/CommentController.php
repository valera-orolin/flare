<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post): Response 
    {
        $comments = Comment::with('user:id,name,user_id')->where('post_id', $post->id)->latest()->get();

        $post->load('user:id,name,user_id')->loadCount(['likes', 'comments']);
        $post->isLikedByUser = $post->isLikedByUser();

        return Inertia::render('Comments/Index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $comment = new Comment();
        $comment->message = $validated['message'];
        $comment->post()->associate($post);
        $comment->user()->associate($request->user());
        $comment->save();
 
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
