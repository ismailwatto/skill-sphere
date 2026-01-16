<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    $conversation = \App\Models\Conversation::find($id);
    return $conversation && ($user->id === $conversation->sender_id || $user->id === $conversation->receiver_id);
});
