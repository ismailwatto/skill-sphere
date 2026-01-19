@extends('layouts.standalone')

@section('title', 'Chat Module Implementation')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-11 col-xl-10 mx-auto">
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Documentation
                </a>
            </div>

            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-primary-soft me-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-chat-dots-fill text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1">Live Chat Module - Complete Implementation</h1>
                        <p class="text-muted mb-0">Copy-paste ready code for a fully functional real-time chat system</p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-success-soft text-success px-3 py-2">Laravel 11</span>
                    <span class="badge bg-info-soft text-info px-3 py-2">Laravel Reverb</span>
                    <span class="badge bg-warning-soft text-warning px-3 py-2">WebSockets</span>
                    <span class="badge bg-danger-soft text-danger px-3 py-2">Real-time</span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">📋 Table of Contents</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step1">1. Install Laravel Reverb</a></li>
                                <li class="mb-2"><a href="#step2">2. Database Migrations</a></li>
                                <li class="mb-2"><a href="#step3">3. Create Models</a></li>
                                <li class="mb-2"><a href="#step4">4. Create Event</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step5">5. Configure Channels</a></li>
                                <li class="mb-2"><a href="#step6">6. Create Controller</a></li>
                                <li class="mb-2"><a href="#step7">7. Create Views</a></li>
                                <li class="mb-2"><a href="#step8">8. Frontend Setup</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 1 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step1">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 1</span>
                        Install Laravel Reverb & Dependencies
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">1.1 Install Reverb Package</h5>
                    <pre class="code-block"><code>composer require laravel/reverb</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">1.2 Install Reverb</h5>
                    <pre class="code-block"><code>php artisan reverb:install</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">1.3 Install Frontend Dependencies</h5>
                    <pre class="code-block"><code>npm install --save-dev laravel-echo pusher-js</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">1.4 Update .env File</h5>
<pre class="code-block"><code>BROADCAST_CONNECTION=reverb

REVERB_APP_ID=136018
REVERB_APP_KEY=erp6zfztg0fah1clio6l
REVERB_APP_SECRET=vgb4cxu6laz7tprf99iy
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"</code></pre>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step2">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 2</span>
                        Create Database Migrations
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">2.1 Create Conversations Migration</h5>
                    <pre class="code-block"><code>php artisan make:migration create_conversations_table</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>database/migrations/xxxx_create_conversations_table.php</code></p>
<pre class="code-block"><code>&lt;?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table-&gt;id();
            $table-&gt;foreignId('sender_id')-&gt;constrained('users')-&gt;onDelete('cascade');
            $table-&gt;foreignId('receiver_id')-&gt;constrained('users')-&gt;onDelete('cascade');
            $table-&gt;timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">2.2 Create Messages Migration</h5>
                    <pre class="code-block"><code>php artisan make:migration create_messages_table</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>database/migrations/xxxx_create_messages_table.php</code></p>
<pre class="code-block"><code>&lt;?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table-&gt;id();
            $table-&gt;foreignId('conversation_id')-&gt;constrained()-&gt;onDelete('cascade');
            $table-&gt;foreignId('sender_id')-&gt;constrained('users')-&gt;onDelete('cascade');
            $table-&gt;text('content');
            $table-&gt;timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">2.3 Run Migrations</h5>
                    <pre class="code-block"><code>php artisan migrate</code></pre>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step3">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 3</span>
                        Create Eloquent Models
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">3.1 Conversation Model</h5>
                    <pre class="code-block"><code>php artisan make:model Conversation</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Models/Conversation.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['sender_id', 'receiver_id'];

    public function messages()
    {
        return $this-&gt;hasMany(Message::class);
    }

    public function sender()
    {
        return $this-&gt;belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this-&gt;belongsTo(User::class, 'receiver_id');
    }

    public function lastMessage()
    {
        return $this-&gt;hasOne(Message::class)-&gt;latest();
    }
}</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">3.2 Message Model</h5>
                    <pre class="code-block"><code>php artisan make:model Message</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Models/Message.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'content'];

    public function conversation()
    {
        return $this-&gt;belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this-&gt;belongsTo(User::class, 'sender_id');
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 4</span>
                        Create Broadcasting Event
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">4.1 Create Event</h5>
                    <pre class="code-block"><code>php artisan make:event MessageSent</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Events/MessageSent.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this-&gt;message-&gt;conversation_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step5">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 5</span>
                        Configure Broadcasting Channels
                    </h3>
                    
                    <p class="text-muted mb-2"><strong>File:</strong> <code>routes/channels.php</code></p>
<pre class="code-block"><code>&lt;?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user-&gt;id === (int) $id;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    $conversation = \App\Models\Conversation::find($id);
    return $conversation &amp;&amp; ($user-&gt;id === $conversation-&gt;sender_id || $user-&gt;id === $conversation-&gt;receiver_id);
});</code></pre>
                </div>
            </div>

            <!-- STEP 6 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step6">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 6</span>
                        Create Chat Controller
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">6.1 Create Controller</h5>
                    <pre class="code-block"><code>php artisan make:controller ChatController</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Http/Controllers/ChatController.php</code></p>
<pre class="code-block"><code>&lt;?php

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
        $users = User::where('id', '!=', Auth::id())-&gt;get();
        
        $conversations = Conversation::where('sender_id', Auth::id())
            -&gt;orWhere('receiver_id', Auth::id())
            -&gt;with(['sender', 'receiver', 'lastMessage'])
            -&gt;get();

        return view('chat.index', compact('users', 'conversations'));
    }

    public function show(User $user)
    {
        $conversation = Conversation::where(function ($query) use ($user) {
            $query-&gt;where('sender_id', Auth::id())
                  -&gt;where('receiver_id', $user-&gt;id);
        })-&gt;orWhere(function ($query) use ($user) {
            $query-&gt;where('sender_id', $user-&gt;id)
                  -&gt;where('receiver_id', Auth::id());
        })-&gt;first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' =&gt; Auth::id(),
                'receiver_id' =&gt; $user-&gt;id,
            ]);
        }

        $messages = $conversation-&gt;messages()-&gt;with('sender')-&gt;get();
        $receiver = $user;
        
        $conversations = Conversation::where('sender_id', Auth::id())
            -&gt;orWhere('receiver_id', Auth::id())
            -&gt;with(['sender', 'receiver', 'lastMessage'])
            -&gt;get();

        return view('chat.show', compact('conversation', 'messages', 'receiver', 'conversations'));
    }

    public function startConversation(User $user)
    {
        return redirect()-&gt;route('chat.show', $user-&gt;name);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request-&gt;validate([
            'content' =&gt; 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' =&gt; $conversation-&gt;id,
            'sender_id' =&gt; Auth::id(),
            'content' =&gt; $request-&gt;content,
        ]);

        try {
            broadcast(new MessageSent($message))-&gt;toOthers();
        } catch (\Exception $e) {
            \Log::error('Broadcast error: ' . $e-&gt;getMessage());
        }

        return response()-&gt;json([
            'status' =&gt; 'Message sent!',
            'message' =&gt; $message-&gt;load('sender'),
        ]);
    }
}</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">6.2 Add Routes</h5>
                    <p class="text-muted mb-2"><strong>File:</strong> <code>routes/web.php</code> (Add inside auth middleware group)</p>
<pre class="code-block"><code>// Chat Routes
Route::middleware('auth')-&gt;group(function () {
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])-&gt;name('chat.index');
    Route::get('/chat/start/{user}', [\App\Http\Controllers\ChatController::class, 'startConversation'])-&gt;name('chat.start');
    Route::get('/chat/{user:name}', [\App\Http\Controllers\ChatController::class, 'show'])-&gt;name('chat.show');
    Route::post('/chat/{conversation}/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])-&gt;name('chat.send');
});</code></pre>
                </div>
            </div>

            <!-- STEP 7 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step7">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 7</span>
                        Create Blade Views
                    </h3>
                    
                    <p class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Create folder: <code>resources/views/chat</code>
                    </p>

                    <h5 class="fw-bold mt-4 mb-3">7.1 Chat Index Page</h5>
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/chat/index.blade.php</code></p>
<pre class="code-block"><code>@@extends('layouts.app')

@@section('title', 'Live Chat')

@@section('content')
&lt;div class="container py-4"&gt;
    &lt;h2 class="fw-bold mb-4"&gt;Messages&lt;/h2&gt;
    
    &lt;div class="row"&gt;
        &lt;div class="col-md-4"&gt;
            &lt;h5&gt;Start New Chat&lt;/h5&gt;
            @@foreach($users as $user)
                &lt;a href="@{{ route('chat.start', $user) }}" class="d-block p-3 border rounded mb-2 text-decoration-none"&gt;
                    &lt;strong&gt;@{{ $user-&gt;name }}&lt;/strong&gt;
                &lt;/a&gt;
            @@endforeach
        &lt;/div&gt;
        
        &lt;div class="col-md-8"&gt;
            &lt;h5&gt;Recent Conversations&lt;/h5&gt;
            @@foreach($conversations as $conversation)
                @@php
                    $otherUser = $conversation-&gt;sender_id === auth()-&gt;id() ? $conversation-&gt;receiver : $conversation-&gt;sender;
                @@endphp
                &lt;a href="@{{ route('chat.show', $otherUser-&gt;name) }}" class="d-block p-3 border rounded mb-2 text-decoration-none"&gt;
                    &lt;strong&gt;@{{ $otherUser-&gt;name }}&lt;/strong&gt;
                    &lt;p class="mb-0 text-muted small"&gt;
                        @@if($conversation-&gt;lastMessage)
                            @{{ $conversation-&gt;lastMessage-&gt;content }}
                        @@endif
                    &lt;/p&gt;
                &lt;/a&gt;
            @@endforeach
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
@@endsection</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">7.2 Chat Conversation Page</h5>
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/chat/show.blade.php</code></p>
<pre class="code-block"><code>@@extends('layouts.app')

@@section('title', 'Chat with ' . $receiver-&gt;name)

@@section('content')
&lt;div class="container py-4"&gt;
    &lt;h2 class="fw-bold mb-4"&gt;Chat with @{{ $receiver-&gt;name }}&lt;/h2&gt;
    
    &lt;div id="messages" class="border rounded p-4 mb-3" style="height: 400px; overflow-y: auto; background: #f8f9fa;"&gt;
        @@foreach($messages as $message)
            &lt;div class="mb-3 @{{ $message-&gt;sender_id === auth()-&gt;id() ? 'text-end' : '' }}"&gt;
                &lt;div class="d-inline-block p-2 rounded @{{ $message-&gt;sender_id === auth()-&gt;id() ? 'bg-primary text-white' : 'bg-white border' }}"&gt;
                    @{{ $message-&gt;content }}
                &lt;/div&gt;
                &lt;div class="small text-muted"&gt;@{{ $message-&gt;created_at-&gt;format('H:i') }}&lt;/div&gt;
            &lt;/div&gt;
        @@endforeach
    &lt;/div&gt;

    &lt;form id="chat-form" class="d-flex gap-2"&gt;
        @@csrf
        &lt;input type="text" id="message-input" class="form-control" placeholder="Type your message..." required&gt;
        &lt;button type="submit" class="btn btn-primary"&gt;Send&lt;/button&gt;
    &lt;/form&gt;
&lt;/div&gt;

&lt;script&gt;
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const conversationId = @{{ $conversation-&gt;id }};

    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    if (window.Echo) {
        window.Echo.private(`chat.${conversationId}`)
            .listen('.MessageSent', (e) =&gt; {
                appendMessage(e.message, false);
            });
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const content = messageInput.value.trim();
        if (!content) return;

        messageInput.value = '';

        fetch('@{{ route("chat.send", $conversation) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '@{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response =&gt; response.json())
        .then(data =&gt; {
            appendMessage(data.message, true);
        });
    });

    function appendMessage(message, isMe) {
        const div = document.createElement('div');
        div.className = `mb-3 ${isMe ? 'text-end' : ''}`;
        div.innerHTML = `
            &lt;div class="d-inline-block p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-white border'}"&gt;
                ${message.content}
            &lt;/div&gt;
            &lt;div class="small text-muted"&gt;${new Date().toLocaleTimeString()}&lt;/div&gt;
        `;
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
&lt;/script&gt;
@@endsection</code></pre>
                </div>
            </div>

            <!-- STEP 8 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step8">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 8</span>
                        Configure Frontend (Laravel Echo)
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">8.1 Create Echo Configuration</h5>
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/js/echo.js</code></p>
<pre class="code-block"><code>import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">8.2 Import Echo in Bootstrap</h5>
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/js/bootstrap.js</code> (Add at the end)</p>
                    <pre class="code-block"><code>import './echo';</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">8.3 Build Assets</h5>
<pre class="code-block"><code>npm run build
# OR for development
npm run dev</code></pre>
                </div>
            </div>

            <!-- RUNNING -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-success-soft">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-success">
                        <i class="bi bi-rocket-takeoff-fill me-2"></i>
                        Running the Application
                    </h3>
                    <p class="lead mb-4">Open <strong>3 separate terminals</strong> and run:</p>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="bg-white p-4 rounded-3 border border-success">
                                <h6 class="fw-bold mb-2 text-success">Terminal 1</h6>
                                <p class="small text-muted mb-2">WebSocket Server</p>
                                <pre class="code-block mb-0"><code>php artisan reverb:start</code></pre>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white p-4 rounded-3 border border-success">
                                <h6 class="fw-bold mb-2 text-success">Terminal 2</h6>
                                <p class="small text-muted mb-2">Queue Worker</p>
                                <pre class="code-block mb-0"><code>php artisan queue:work</code></pre>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white p-4 rounded-3 border border-success">
                                <h6 class="fw-bold mb-2 text-success">Terminal 3</h6>
                                <p class="small text-muted mb-2">Asset Bundler</p>
                                <pre class="code-block mb-0"><code>npm run dev</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4 mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Alternative:</strong> Change <code>QUEUE_CONNECTION=database</code> to <code>QUEUE_CONNECTION=sync</code> in .env
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 mb-5">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-arrow-left me-2"></i>Back to Documentation Home
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.code-block {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1.25rem;
    border-radius: 8px;
    overflow-x: auto;
    font-family: 'Fira Code', 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 0;
}

.code-block code {
    background: transparent;
    color: #d4d4d4;
    padding: 0;
}

.bg-danger-soft {
    background-color: rgba(239, 68, 68, 0.08);
}
</style>
@endsection
