@extends('layouts.app')

@section('title', 'Live Chat')

@section('content')
<div class="chat-container">
    <!-- Sidebar -->
    <div class="chat-sidebar bg-white">
        <div class="p-4 border-bottom">
            <h5 class="fw-bold mb-0">Messages</h5>
        </div>
        
        <div class="flex-grow-1 overflow-auto p-3">
            <h6 class="form-label-refined mb-3">Recent Conversations</h6>
            @if($conversations->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-chat-left-dots text-muted fs-1 opacity-25"></i>
                    <p class="text-muted small mt-2">No conversations yet</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($conversations as $conversation)
                        @php
                            $otherUser = $conversation->sender_id === auth()->id() ? $conversation->receiver : $conversation->sender;
                        @endphp
                        <a href="{{ route('chat.show', $otherUser->name) }}" class="chat-user-item list-group-item list-group-item-action border-0 mb-2 p-3 d-flex align-items-center {{ request()->routeIs('chat.show') && isset($receiver) && $receiver->id == $otherUser->id ? 'active' : '' }}">
                            <div class="position-relative me-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&color=7F9CF5&background=EBF4FF" class="rounded-circle" width="45" height="45" alt="avatar">
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"></span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold text-truncate">{{ $otherUser->name }}</h6>
                                    <span class="extra-small text-muted">{{ $conversation->updated_at->diffForHumans(null, true) }}</span>
                                </div>
                                <p class="extra-small text-muted mb-0 text-truncate">
                                    @if($conversation->lastMessage)
                                        {{ $conversation->lastMessage->sender_id === auth()->id() ? 'You: ' : '' }}{{ $conversation->lastMessage->content }}
                                    @else
                                        No messages yet.
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <h6 class="form-label-refined mt-4 mb-3">Available Users</h6>
            <div class="list-group list-group-flush">
                @foreach($users as $user)
                    <a href="{{ route('chat.start', $user) }}" class="chat-user-item list-group-item list-group-item-action border-0 mb-2 p-3 d-flex align-items-center">
                        <div class="me-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=4361ee&background=f1f5f9" class="rounded-circle" width="40" height="40" alt="avatar">
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold small text-dark">{{ $user->name }}</h6>
                            <span class="extra-small text-muted">{{ $user->email }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Empty State / Welcome -->
    <div class="chat-messages-wrapper d-none d-md-flex align-items-center justify-content-center bg-light">
        <div class="text-center p-5">
            <div class="icon-box bg-primary-soft mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="bi bi-chat-quote"></i>
            </div>
            <h4 class="fw-bold">Your Messages</h4>
            <p class="text-muted">Select a conversation from the sidebar to start chatting with your team or customers.</p>
        </div>
    </div>
</div>
@endsection
