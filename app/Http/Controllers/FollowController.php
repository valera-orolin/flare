<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function friends(Request $request): Response
    {
        $users = $request->user()->friends()->get();

        foreach ($users as $user) {
            $user->isFollowedByUser = $user->isFollowedByUser();
        }

        return Inertia::render('Follows/Index', [
            'users' => $users,
        ]);
    }

    public function followers(User $user): Response
    {
        $followers = $user->followers()->get();

        foreach ($followers as $follower) {
            $follower->isFollowedByUser = $follower->isFollowedByUser();
        }

        return Inertia::render('Follows/Index', [
            'users' => $followers,
        ]);
    }

    public function followees(User $user): Response
    {
        $followees = $user->followees()->get();

        foreach ($followees as $followee) {
            $followee->isFollowedByUser = $followee->isFollowedByUser();
        }

        return Inertia::render('Follows/Index', [
            'users' => $followees,
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
        $follower = $request->user();
        $followee = User::find($request->input('followee_id'));

        $follow = Follow::where('follower_id', $follower->id)
            ->where('followee_id', $followee->id)
            ->first();

        if ($follow) {
            $follow->delete();
        } else if ($follower->id == $followee->id) {
            response('', 409);
        } else {
            $follow = new Follow();
            $follow->follower()->associate($follower);
            $follow->followee()->associate($followee);
            $follow->save();
        }

        return response('', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Follow $follow)
    {
        //
    }
}
