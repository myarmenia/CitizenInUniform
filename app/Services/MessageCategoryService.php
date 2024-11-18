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

        return $this->messageCategoryRepository->store($data->toArray());
    }
    public function show($id){

        return $this->messageCategoryRepository->show($id);

    }
    public function update($data,$id){

        return $this->messageCategoryRepository->update($data->toArray(),$id);

    }
}
