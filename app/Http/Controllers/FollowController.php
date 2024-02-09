<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    /**
     * Display a paginated listing of the friends for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function friends(Request $request): Response
    {
        $users = $request->user()->friends()->paginate(15);

        foreach ($users as $user) {
            $user->isFollowedByUser = $user->isFollowedByUser();
        }

        return Inertia::render('Follows/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Display a paginated listing of the followers for the given user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function followers(User $user): Response
    {
        $followers = $user->followers()->paginate(15);

        foreach ($followers as $follower) {
            $follower->isFollowedByUser = $follower->isFollowedByUser();
        }

        return Inertia::render('Follows/Index', [
            'users' => $followers,
        ]);
    }

    /**
     * Display a paginated listing of the followees for the given user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function followees(User $user): Response
    {
        $followees = $user->followees()->paginate(15);

        foreach ($followees as $followee) {
            $followee->isFollowedByUser = $followee->isFollowedByUser();
        }

        return Inertia::render('Follows/Index', [
            'users' => $followees,
        ]);
    }

    /**
     * Store a newly created follow in storage or delete an existing one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
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
     * Fetch a list of suggested users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggestedUsers(): JsonResponse
    {
        $users = User::limit(3)->get();

        return response()->json($users);
    }
}
