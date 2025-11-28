<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports.
|
*/

Broadcast::channel('chat.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.channel.{channel}', function ($user, $channel) {
    // For now allow any authenticated user to listen to group channels.
    // You can later restrict based on roles or membership.
    return Auth::check();
});
