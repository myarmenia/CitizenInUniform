<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use Illuminate\Http\Request;
use Storage;

class CategoryService
{
    public function __construct(
        protected CategoryInterface $categorryRepository
    ) {
    }

    public function index(){
        return $this->categorryRepository->index();
    }

    public function store($data)
    {

        $category = $this->categorryRepository->store($data->toArray());

        $path = FileUploadService::upload($data->file, "categories/$category->id");
        $data->path = $path;

        return $this->categorryRepository->update($data->toArray(), $category->id);

    }

    public function getItem($id)
    {
        return $this->categorryRepository->getItem($id);
    }

    public function update($data, $id)
    {

        if($data->file){

            $path = $this->addFile($data->file, $id);
            $data->path = $path;
        }

        return $this->categorryRepository->update($data->toArray(), $id);
    }
    public function activeCategories()
    {
        return $this->categorryRepository->activeCategories();
    }


    public function addFile($file, $categoryId)
    {

        try {

            $old_path = $this->getItem($categoryId)->path;
            Storage::delete($old_path);

            $path = FileUploadService::upload($file, "categories/$categoryId");

            return $path;

        } catch (\Throwable $th) {
            return false;
        }

    }

}
