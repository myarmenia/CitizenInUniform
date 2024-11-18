<?php
namespace App\Services;

use App\Interfaces\MessageCategoryInterface;

class MessageCategoryService
{
    public function __construct(protected MessageCategoryInterface $messageCategoryRepository ){


    }

    public function index(){

        return $this->messageCategoryRepository->index();
    }
    public function store($data){
       
        return $this->messageCategoryRepository->store($data);
    }
}
