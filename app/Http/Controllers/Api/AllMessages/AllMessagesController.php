<?php

namespace App\Http\Controllers\Api\AllMessages;

use App\Helpers\MyHelper;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Interfaces\AllMessageInterface;
use App\Interfaces\ChatMessageInterface;
use App\Interfaces\EmailMessageAnswerInterface;
use Illuminate\Http\Request;

class AllMessagesController extends BaseController
{
    public function __construct(protected AllMessageInterface $allMessageRepository )
    {

    }
    public function __invoke()
    {
        $governing_id = MyHelper::getGoverningBodyIdFromOperator();
        $emailMessagesCount = $this->allMessageRepository->emailMessage()->count();

        $chatMessagesCount = $this->allMessageRepository->chatMessage()->count();

        $data = [
            'email_messages_count' =>  $emailMessagesCount,
            'chat_messages_count' =>  $chatMessagesCount,
            'governing_body_id' => $governing_id

        ];

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
