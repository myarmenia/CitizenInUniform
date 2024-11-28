<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


Broadcast::channel('messages-count.{governingId}', function ($user, $governingId) {
    // Здесь вы можете проверить, имеет ли пользователь доступ к этому governing_id
    // return $user->canAccessGoverningId($governingId); // Настройте метод в модели User
    // dd(22);
    return true;
});
