<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     * Store a newly created like in storage or delete an existing one.
     *
     * The like is associated with the authenticated user and the post with the given id.
     * If a like already exists, it is deleted. If the post does not exist, a 404 response is returned.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
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
}
