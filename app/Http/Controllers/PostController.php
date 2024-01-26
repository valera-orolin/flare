<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response 
    {
        $posts = Post::with('user:id,name,user_id,avatar')->withCount('likes')->withCount('comments')->latest()->paginate(15);

        foreach ($posts as $post) {
            $post->increment('views_count');
            $post->isLikedByUser = $post->isLikedByUser();
            $post->user->isFollowedByUser = $post->user->isFollowedByUser();
        }

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
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
    public function store(Request $request)
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
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
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
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
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
