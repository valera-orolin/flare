<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    /**
     * Display a paginated listing of the chats for the authenticated user.
     *
     * For each chat, it includes the interlocutor's details (name, user_id, id, avatar)
     * and the content and creation time of the last message if it exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
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
}
