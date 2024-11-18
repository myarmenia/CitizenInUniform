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



}
