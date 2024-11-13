<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\EmailMessageInterface;
use Illuminate\Http\Request;
use Storage;

class EmailMessageService
{
    public function __construct(
        protected EmailMessageInterface $emailMessageRepository
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
