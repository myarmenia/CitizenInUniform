<?php
namespace App\Repositories;

use App\Interfaces\MessageCategoryInterface;
use App\Models\MessageCategory;

class MessageCategoryRepository implements MessageCategoryInterface{

    public  function index(){

        return MessageCategory::all();

    }
    public  function store($data){


        return MessageCategory::create($data);


    }
    public function show($id){
        return MessageCategory::findOrFail($id);
    }
    public function update($data,$id){


        $messageCategory = MessageCategory::find($id);

        return  $messageCategory ? $messageCategory->update($data) : false;

    }



}
