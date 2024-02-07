<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a paginated listing of the posts.
     *
     * Each post includes the user's details (id, name, user_id, avatar), the count of likes and comments,
     * a flag indicating whether the post is liked by the authenticated user,
     * and a flag indicating whether the user is followed by the authenticated user.
     * The views count of each post is incremented.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request): Response 
    {
        $search = $request->input('search');

        /** @var \Illuminate\Database\Eloquent\Collection|Post[] $posts */
        $posts = Post::search($search)->orderBy('id', 'desc')->paginate(15);

        $posts->each(function ($post) {
            $post->load('user:id,name,user_id,avatar');
            $post->loadCount(['likes', 'comments']);
            $post->increment('views_count');
            $post->isLikedByUser = $post->isLikedByUser();
            $post->user->isFollowedByUser = $post->user->isFollowedByUser();
        });

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created post in storage.
     *
     * The post is associated with the authenticated user.
     * The message, image, and visibility of the post are validated before storing.
     * If an image is uploaded, it is stored and its path is included in the post.
     * After storing, the post is loaded with the user's details (id, name, user_id, avatar).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'image' => 'nullable|image',
            'visibility' => 'required|in:public,only_friends',
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = '/storage/' . $path;
        }
 
        $post = $request->user()->posts()->create($validated);

        $post->load('user:id,name,user_id,avatar');
 
        return response()->json($post);
    }

    /**
     * Update the specified post in storage.
     *
     * The post is updated if the authenticated user is authorized to update it.
     * The message, image, and visibility of the post are validated before updating.
     * If an image is uploaded, the old image is deleted, the new image is stored, and its path is included in the post.
     * After updating, the post is loaded with the user's details (id, name, user_id, avatar).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'image' => 'nullable|image',
            'visibility' => 'required|in:public,only_friends',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->image));
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = '/storage/' . $path;
        }
 
        $post->update($validated);

        $post->load('user:id,name,user_id,avatar');
 
        return response()->json($post);
    }

    /**
     * Remove the specified post from storage.
     *
     * The post is deleted if the authenticated user is authorized to delete it.
     * If the post has an image, it is deleted.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);
 
        if ($post->image) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->image));
        }

        $postid = $post->id;
        $post->delete();
 
        return response()->json($postid);
    }
}
