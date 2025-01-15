<?php

namespace App\Services;


use App\Events\ChatMessagesEvent;
use App\Helpers\MyHelper;
use App\Interfaces\CategoryInterface;
use App\Interfaces\EmailMessageAnswerInterface;
use App\Interfaces\EmailMessageInterface;
use App\Mail\SendEmailMessage;
use App\Models\Message;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Storage;

class EmailMessageService
{
    public function __construct(
        protected EmailMessageInterface $emailMessageRepository,
        protected EmailMessageAnswerInterface $emailMessageAnswerRepo
    ) {
    }

    public function index(){
        return $this->emailMessageRepository->index();
    }

    public function store($data)
    {
        // dd($data);
        return $this->emailMessageRepository->store($data->toArray());

    }

    public function getItem($id)
    {
        return $this->emailMessageRepository->getItem($id);
    }

    public function storeAnswer($data)
    {



        try {
            $data['user_id'] = Auth::id();

            $message_content = $data['content'];
            $data['content'] = MyHelper::encryptData($data['content']);

            $messageAnswer = $this->emailMessageAnswerRepo->store($data);
            $email_message = $messageAnswer->email_message;
            $email = $email_message->email;
            $subject = $email_message->message_category_withTrashed->title;

            $governing_body = $email_message->governing_body;

            $message['message_title'] = $governing_body->name;
            $message['content'] = $message_content;
            $message['mobile_user_content'] = MyHelper::decryptData($email_message->content);

            $mailer_name = $governing_body->named;
            $mailer = "smtp_$mailer_name";

            Mail::mailer($mailer)->send(new SendEmailMessage($message, $subject, $email, $mailer_name));


        } catch (\Throwable $th) {
            throw $th;
        }

        return $messageAnswer;

    }

    public function chatMessageCount($id){

        $message = Message::where('id', $id)->first();

        $unAnsweredCount = Message::where('readed', 0)->where('writer', 'user');
        $userId = $message->room ? $message->room->operator_id : null;

        if ($userId != null) {
            $unAnsweredCount->whereHas('room', function ($query) use ($userId) {
                $query->where('operator_id', $userId);
            });

        }

        $unAnsweredCount = $unAnsweredCount->count();

        event(
            new ChatMessagesEvent($unAnsweredCount, 'chat_message', $userId)
        );

        return true;
    }



}
