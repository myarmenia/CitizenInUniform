<?php

namespace App\Observers;

use App\Events\MessagesEvent;
use App\Models\EmailMessages;

class EmailMessagesObserver
{
    /**
     * Handle the EmailMessages "created" event.
     */
    public function created(EmailMessages $emailMessages): void
    {
        $governingId = $emailMessages->governing_body_id;
        $unAnsweredCount = EmailMessages::where('has_answer', 0)->where('governing_body_id', $governingId)->count();

        event(
            new MessagesEvent($unAnsweredCount, 'email_message', $governingId)
        );
    }

    /**
     * Handle the EmailMessages "updated" event.
     */
    public function updated(EmailMessages $emailMessages): void
    {
        // $unAnsweredCount = EmailMessages::where('has_answer', 0)->get()->count();

        // event(
        //     new MessagesEvent($unAnsweredCount, 'email_message')
        // );
    }

    /**
     * Handle the EmailMessages "deleted" event.
     */
    public function deleted(EmailMessages $emailMessages): void
    {
        //
    }

    /**
     * Handle the EmailMessages "restored" event.
     */
    public function restored(EmailMessages $emailMessages): void
    {
        //
    }

    /**
     * Handle the EmailMessages "force deleted" event.
     */
    public function forceDeleted(EmailMessages $emailMessages): void
    {
        //
    }
}
