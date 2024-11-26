<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\AllMessageInterface;
use App\Interfaces\ChatMessageInterface;
use App\Models\EmailMessages;
use App\Models\Message;
use Auth;


class AllMessageRepository implements AllMessageInterface
{
    public function emailMessage()
    {

        $governing_id = MyHelper::getGoverningBodyIdFromOperator();

        $query = EmailMessages::where('has_answer', 0);

        if ($governing_id != null) {
            $query->where('governing_body_id', $governing_id);
        }

        $query = $query->get();

        if ($governing_id != null || Auth::user()->hasRole('super_admin')) {
            return $query;
        }

        return false;
    }

    public function chatMessage()
    {
        $governing_id = MyHelper::getGoverningBodyIdFromOperator();

        $query = Message::where('readed', 0)->where('writer', 'user');

        if ($governing_id != null) {
            $query->whereHas('room', function ($query) use ($governing_id) {
                $query->where('governing_body_id', $governing_id);
            });

        }

        $query = $query->get();

        if ($governing_id != null || Auth::user()->hasRole('super_admin')) {
            return $query;
        }

        return false;

    }



}
