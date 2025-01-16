<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\EmailMessageInterface;
use App\Models\EmailMessages;
use App\Services\FileUploadService;
use Auth;
use Illuminate\Support\Arr;

class EmailMessageRepository implements EmailMessageInterface
{
    public function index(){
        $request = request();
        $governing_id = MyHelper::getAuthUserGoverningBodyId();

        $request = array_filter($request->all(), fn($value) => $value !== null);

        $query = EmailMessages::query();

        if($governing_id != null){
            $query->where('governing_body_id', $governing_id);
        }

        $query = $query->filter($request)->orderBy('id', 'desc')->get();

        if ($governing_id != null || Auth::user()->hasRole('super_admin')) {
            return $query;
        }

        return  false;
    }

    public function store($data): EmailMessages
    {

        if(is_array($data['governing_body_id'])){

            $governing_body_ids = $data['governing_body_id'];
            foreach ($governing_body_ids as $key => $value) {

                $data['governing_body_id'] = $value;
                $data['content'] = MyHelper::encryptData($data['content']);
                $message = EmailMessages::create($data);
            }
        }

        else{
            $data['content'] = MyHelper::encryptData($data['content']);

            $files = $data['files'];

            $data_without_files= Arr::forget($data, 'files');

            $message = EmailMessages::create($data);

           if(!empty($files)){
            $email_messages_file=[];
                foreach($files as $file){

                    $path = FileUploadService::upload( $file,  'email_messages/' . $message->id);
                    $email_messages_file[] = [
                      'path' => $path,
                      'name' => $file->getClientOriginalName()
                    ];
                }

                $message->email_messages_files()->createMany($email_messages_file);

            }



        }

        return $message;
    }

    public function getItem(string $id){
        return EmailMessages::find($id);
    }



}
