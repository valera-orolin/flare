<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $post = Post::find($request->input('post_id'));
        if (!$post) {
            return response('', 404);
        }

        $like = Like::where('user_id', $request->user()->id)
                ->where('post_id', $post->id)
                ->first();

        if ($like) {
            $like->delete();
        } else {
            $like = new Like();
            $like->post()->associate($post);
            $like->user()->associate($request->user());
            $like->save();
        }

        return response('', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
