<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        
        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver', 'lastMessage'])
            ->get();

        return view('chat.index', compact('users', 'conversations'));
    }

    public function show(User $user)
    {
        // Find or create conversation between Auth::user() and $user
        $conversation = Conversation::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
            ]);
        }

        $messages = $conversation->messages()->with('sender')->get();
        $receiver = $user;
        
        // Fetch all conversations for the sidebar
        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver', 'lastMessage'])
            ->get();

        return view('chat.show', compact('conversation', 'messages', 'receiver', 'conversations'));
    }

    public function startConversation(User $user)
    {
        return redirect()->route('chat.show', $user->name);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
        ]);

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            // Log error or ignore if reverb is down
            \Log::error('Broadcast error: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'Message sent!',
            'message' => $message->load('sender'),
        ]);
    }
}
