<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{id}', function ($authUser, $id) {
    Log::info("Channel auth: {$authUser->id} trying user.{$id}");
    return (int) $authUser->id === (int) $id;
});
