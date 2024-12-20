<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\EmailMessageInterface;
use App\Models\EmailMessages;
use Auth;


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

                $message = EmailMessages::create($data);
            }
        }
        else{
            $message = EmailMessages::create($data);
        }

        return $message;
    }

    public function getItem(string $id){
        return EmailMessages::find($id);
    }



}
