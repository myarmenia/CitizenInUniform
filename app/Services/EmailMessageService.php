<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\EmailMessageAnswerInterface;
use App\Interfaces\EmailMessageInterface;
use App\Mail\SendEmailMessage;
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

            $messageAnswer = $this->emailMessageAnswerRepo->store($data);
            $email_message = $messageAnswer->email_message;
            $email = $email_message->email;
            $subject = $email_message->message_category->title;

            $governing_body = $email_message->governing_body;

            $message['message_title'] = $governing_body->name;
            $message['content'] = $data['content'];
            
            $mailer_name = $governing_body->named;
            $mailer = "smtp_$mailer_name";

            Mail::mailer($mailer)->send(new SendEmailMessage($message, $subject, $email));


        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->emailMessageAnswerRepo->store($data);

    }

    // public function update($data, $id)
    // {

    //     if($data->file){

    //         $path = $this->addFile($data->file, $id);
    //         $data->path = $path;
    //     }

    //     return $this->categorryRepository->update($data->toArray(), $id);
    // }
    // public function activeCategories()
    // {
    //     return $this->categorryRepository->activeCategories();
    // }


    // public function addFile($file, $categoryId)
    // {

    //     try {

    //         $old_path = $this->getItem($categoryId)->path;
    //         Storage::delete($old_path);

    //         $path = FileUploadService::upload($file, "categories/$categoryId");

    //         return $path;

    //     } catch (\Throwable $th) {
    //         return false;
    //     }

    // }

}
