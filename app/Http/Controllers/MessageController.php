<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $interlocutor = $user;

        $chats = $request->user()->chats()->get();

        $chat = $chats->first(function ($chat) use ($interlocutor) {
            return $chat->user1_id == $interlocutor->id || $chat->user2_id == $interlocutor->id;
        });

        if (!$chat) {
            $chat = Chat::create([
                'user1_id' => $request->user()->id,
                'user2_id' => $interlocutor->id,
            ]);
        }

        $messages = $chat->messages()->with('user:id,name')->get();

        return Inertia::render('Chats/Show', [
            'messages' => $messages,
            'chat' => $chat,
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
    public function store(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
 
        $message = new Message;
        $message->content = $validated['content'];
        $message->user_id = $request->user()->id;
        $message->chat_id = $chat->id;
        $message->save();
;
        $message->load('user:id,name,user_id,avatar');
        broadcast(new MessageSent($message))->toOthers();
 
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
