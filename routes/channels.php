<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('user.{id}', function ($authUser, $id) {
    Log::info("Channel auth: {$authUser->id} trying user.{$id}");
    return (int) $authUser->id === (int) $id;
});

Broadcast::channel('chat.{roomId}', function ($roomId) {
    Log::debug("message channel auth for room: {$roomId}");
    return true;
});
