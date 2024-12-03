<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


Broadcast::channel('messages-count.{governingId}', function ($user, $governingId) {

    return $user->canAccessGoverningId($governingId);
});


Broadcast::channel('chat-messages-count.{userId}', function ($user, $userId) {

    return $userId == $user->id ? true : false;
});
