<?php

namespace App\Observers;

use App\Events\ChatMessagesEvent;
use App\Events\MessagesEvent;
use App\Models\Message;
use App\Models\User;
use Auth;

class ChatMessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {

        $governingId = $message->room ? $message->room->governing_body_id : null;
        $roomId = $message->room_id;

        // $unAnsweredCount = Message::where('readed', 0)->where('governing_body_id', $governingId)->count();
        $unAnsweredCount = Message::where('readed', 0)->where('writer', 'user');
        $userId = $message->room ? $message->room->operator_id : null;




        if ($userId != null) {
            $unAnsweredCount->whereHas('room', function ($query) use ($userId) {

                $query->where('operator_id', $userId);
            });

        }

        $unAnsweredCount = $unAnsweredCount->count();

        event(
            new ChatMessagesEvent($unAnsweredCount, 'chat_message', $roomId)
        );
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        // $unAnsweredCount = Message::where('readed', 0)->get()->count();

        // event(
        //     new MessagesEvent($unAnsweredCount, 'chat_message')
        // );

        $governingId = $message->room ? $message->room->governing_body_id : null;
        // $unAnsweredCount = Message::where('readed', 0)->where('governing_body_id', $governingId)->count();
        $unAnsweredCount = Message::where('readed', 0)->where('writer', 'user');
        $userId = $message->room ? $message->room->operator_id : null;

        if ($governingId != null && $userId != null) {
            $unAnsweredCount->whereHas('room', function ($query) use ($governingId, $userId) {
                $query->where('governing_body_id', $governingId)->where('operator_id', $userId);
            });

        }

        $unAnsweredCount = $unAnsweredCount->count();

        event(
            new ChatMessagesEvent($unAnsweredCount, 'chat_message', $governingId)
        );
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
