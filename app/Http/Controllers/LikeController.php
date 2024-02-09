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
