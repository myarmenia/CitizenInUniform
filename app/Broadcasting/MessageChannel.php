<?php

namespace App\Broadcasting;

use App\Models\GoverningBodyUser;
use App\Models\User;

class MessageChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */

    public function join(User $user, GoverningBodyUser $body): array|bool
    {
        return true;
    }
}
