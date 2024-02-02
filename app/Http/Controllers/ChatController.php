<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chats = $request->user()->chats()->paginate(15);

        foreach ($chats as $chat) {
            $interlocutor = $chat->user(1)->getResults()->id == $request->user()->id ? $chat->user(2)->getResults() : $chat->user(1)->getResults();
            $chat->interlocutor = $interlocutor->only(['name', 'user_id', 'id', 'avatar']);
            
            $last_message = $chat->messages()->latest()->first();
            if ($last_message) {
                $chat->last_message = $last_message->only(['content', 'created_at']);
            }
        }

        return Inertia::render('Chats/Index', [
            'chats' => $chats
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
