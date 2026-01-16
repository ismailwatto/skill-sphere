@extends('layouts.app')

@section('title', 'Chat with ' . $receiver->name)

@section('content')
<div class="chat-container">
    <!-- Sidebar (Hidden on mobile) -->
    <div class="chat-sidebar bg-white d-none d-lg-flex">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Messages</h5>
            <a href="{{ route('chat.index') }}" class="btn btn-sm btn-light rounded-pill"><i class="bi bi-plus-lg"></i></a>
        </div>
        
        <div class="flex-grow-1 overflow-auto p-3">
            <h6 class="form-label-refined mb-3">Recent Conversations</h6>
            <div class="list-group list-group-flush">
                @foreach($conversations as $conv)
                    @php
                        $otherU = $conv->sender_id === auth()->id() ? $conv->receiver : $conv->sender;
                    @endphp
                    <a href="{{ route('chat.show', $otherU->name) }}" class="chat-user-item list-group-item list-group-item-action border-0 mb-2 p-3 d-flex align-items-center {{ $receiver->id == $otherU->id ? 'active' : '' }}">
                        <div class="position-relative me-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($otherU->name) }}&color=7F9CF5&background=EBF4FF" class="rounded-circle" width="45" height="45" alt="avatar">
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex justify-between align-items-center mb-1">
                                <h6 class="mb-0 fw-bold text-truncate small" style="color: black !important;">{{ $otherU->name }}</h6>
                                <span class="extra-small text-muted">{{ $conv->updated_at->diffForHumans(null, true) }}</span>
                            </div>
                            <p class="extra-small text-muted mb-0 text-truncate">
                                @if($conv->lastMessage)
                                    {{ $conv->lastMessage->sender_id === auth()->id() ? 'You: ' : '' }}{{ $conv->lastMessage->content }}
                                @else
                                    No messages yet.
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Chat Area -->
    <div class="chat-messages-wrapper overflow-hidden">
        <!-- Chat Header -->
        <div class="p-3 bg-white border-bottom d-flex align-items-center justify-content-between shadow-sm">
            <div class="d-flex align-items-center">
                <a href="{{ route('chat.index') }}" class="btn btn-header-action me-3 d-lg-none">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <div class="position-relative me-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($receiver->name) }}&color=7F9CF5&background=EBF4FF" class="rounded-circle" width="40" height="40" alt="avatar">
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"></span>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold" style="color: black !important;">{{ $receiver->name }}</h6>
                    <span class="extra-small text-success">Online</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-header-action rounded-circle"><i class="bi bi-telephone"></i></button>
                <button class="btn btn-header-action rounded-circle"><i class="bi bi-camera-video"></i></button>
                <button class="btn btn-header-action rounded-circle"><i class="bi bi-three-dots-vertical"></i></button>
            </div>
        </div>

        <!-- Messages scroll area -->
        <div id="messages" class="flex-grow-1 p-4 overflow-auto d-flex flex-column gap-3">
            @foreach($messages as $message)
                <div class="d-flex flex-column {{ $message->sender_id === auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                    <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'chat-bubble-me shadow-sm' : 'chat-bubble-other shadow-sm' }}">
                        {{ $message->content }}
                    </div>
                    <span class="extra-small text-muted mt-1 px-2">
                        {{ $message->created_at->format('H:i') }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-top shadow-lg">
            <form id="chat-form" class="input-group-refined p-1">
                @csrf
                <button type="button" class="btn btn-header-action rounded-circle me-1">
                    <i class="bi bi-plus-circle"></i>
                </button>
                <input type="text" id="message-input" autocomplete="off" 
                       class="form-control border-0 bg-transparent" 
                       placeholder="Type your message here...">
                <button type="button" class="btn btn-header-action rounded-circle me-1 text-muted">
                    <i class="bi bi-emoji-smile"></i>
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 ms-2">
                    <i class="bi bi-send-fill me-2"></i> Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messagesContainer = document.getElementById('messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const currentUserId = {{ auth()->id() }};
        const conversationId = {{ $conversation->id }};

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        function appendMessage(message, isMe) {
            const div = document.createElement('div');
            div.className = `d-flex flex-column ${isMe ? 'align-items-end' : 'align-items-start'}`;
            
            const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            div.innerHTML = `
                <div class="chat-bubble ${isMe ? 'chat-bubble-me shadow-sm' : 'chat-bubble-other shadow-sm'}">
                    ${message.content}
                </div>
                <span class="extra-small text-muted mt-1 px-2">
                    ${time}
                </span>
            `;
            
            messagesContainer.appendChild(div);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Listen for messages
        if (window.Echo) {
            console.log('Echo is initialized, listening on channel chat.' + conversationId);
            window.Echo.private(`chat.${conversationId}`)
                .subscribed(() => {
                    console.log('Successfully subscribed to private channel chat.' + conversationId);
                })
                .listen('.MessageSent', (e) => {
                    console.log('Received message:', e);
                    appendMessage(e.message, false);
                });
        } else {
            console.error('Echo is not initialized. Make sure you have run npm run build/dev.');
        }

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const content = messageInput.value.trim();
            if (!content) return;

            messageInput.value = '';

            fetch(`{{ route('chat.send', $conversation) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: content })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Server error');
                }
                return data;
            })
            .then(data => {
                appendMessage(data.message, true);
            })
            .catch(error => {
                console.error('Chat Error:', error);
                // Gracefully handle or show a small alert
            });
        });
    });
</script>
@endsection
