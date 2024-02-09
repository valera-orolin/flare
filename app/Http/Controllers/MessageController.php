<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages for the chat between the authenticated user and the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function index(Request $request, User $user): Response
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
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Chat $chat): JsonResponse
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
}
