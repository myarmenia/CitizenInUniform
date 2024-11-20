<?php

namespace App\Observers;

use App\Events\MessagesEvent;
use App\Models\Message;

class ChatMessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        $unAnsweredCount = Message::where('has_answer', 0)->get()->count();

        event(
            new MessagesEvent($unAnsweredCount, 'chat_message')
        );
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
