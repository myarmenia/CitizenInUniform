<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\EmailMessageInterface;
use App\Models\EmailMessages;


class EmailMessageRepository implements EmailMessageInterface
{
    public function index(){
        $request = request();
        $governing_id = MyHelper::getGoverningBodyIdFromOperator();

        $request = array_filter($request->all(), fn($value) => $value !== null);

        $query = EmailMessages::query();

        if($governing_id != null){
            $query->where('governing_body_id', $governing_id);
        }

        $query = $query->filter($request)->get();

        return  $query;
    }

    public function store($data): EmailMessages
    {
        return EmailMessages::create($data);
    }

    public function getItem(string $id){
        return EmailMessages::find($id);
    }

    

}
