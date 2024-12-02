<?php

namespace App\Http\Controllers\Api\AllMessages;

use App\Helpers\MyHelper;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Interfaces\AllMessageInterface;
use App\Interfaces\ChatMessageInterface;
use App\Interfaces\EmailMessageAnswerInterface;
use Auth;
use Illuminate\Http\Request;

class AllMessagesController extends BaseController
{
    public function __construct(protected AllMessageInterface $allMessageRepository )
    {

    }
    public function __invoke()
    {
        $governing_id = MyHelper::getGoverningBodyIdFromOperator();

        $emailMessagesCount = $this->allMessageRepository->emailMessage();
        $chatMessagesCount = $this->allMessageRepository->chatMessage();

        $user = Auth::user();
        $room_ids = $user->rooms ? $user->rooms->pluck('id')->toArray() : null;

        $data = [
            'email_messages_count' =>  $emailMessagesCount ?? 0,
            'chat_messages_count' =>  $chatMessagesCount ?? 0,
            'governing_body_id' => $governing_id,
            'room_ids' => $room_ids

        ];

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
