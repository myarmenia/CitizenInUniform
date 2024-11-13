<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\EmailMessageInterface;
use App\Models\EmailMessages;


class EmailMessageRepository implements EmailMessageInterface
{
    public function index(){

        $governing_id = MyHelper::getGoverningBodyIdFromOperator();
        $answered = request()->answered;
        $query = EmailMessages::where('has_answer', $answered);

        if($governing_id != null){
            $query->where('governing_body_id', $governing_id);
        }

        return  $query->get();
    }

    public function store($data): EmailMessages
    {
        return EmailMessages::create($data);
    }

    public function getItem(string $id){
        return EmailMessages::find($id);
    }

    // public function update($data, string $id){

    //     $category = Category::find($id);
    //     return $category ? $category->update($data) : false;
    // }


    // public function activeCategories(){

    //     return Category::where('status',1)->get();

    // }

}
