<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Display a paginated listing of the comments for the given post.
     *
     * Each comment includes the user's details (id, name, user_id, avatar).
     * The post is loaded with the user's details and the count of likes and comments.
     * It also includes a flag indicating whether the post is liked by the authenticated user.
     *
     * @param  \App\Models\Post  $post
     * @return \Inertia\Response
     */
    public function index(Post $post): Response 
    {
        $comments = Comment::with('user:id,name,user_id,avatar')->where('post_id', $post->id)->latest()->paginate(15);

        $post->load('user:id,name,user_id,avatar')->loadCount(['likes', 'comments']);
        $post->isLikedByUser = $post->isLikedByUser();

        return Inertia::render('Comments/Index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    /**
     * Store a newly created comment in storage.
     *
     * The comment is associated with the given post and the authenticated user.
     * The message of the comment is validated before storing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post): RedirectResponse
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
}
