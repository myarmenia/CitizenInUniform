<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\FileInterface;
use App\Interfaces\SubCategoryInterface;

class SubCategoryService
{
    public function __construct(
        protected SubCategoryInterface $subCategorryRepository,
        protected CategoryInterface $categoryRepository,
        protected FileInterface $fileRepository

    ) {
    }

    public function index(){
        return $this->subCategorryRepository->index();
    }

    public function create()
    {
        return $this->categoryRepository->index();
    }

    public function store($data)
    {

        $dataFile = [];
        $subCategory = $this->subCategorryRepository->store($data->toArray());

        if($data->files != null && $subCategory != null){

            $files = $data->files;
            foreach ($files as $key => $value) {


                $type = !$value->getError() ? explode('/', $value->getMimeType())[0] : null;

                $path = FileUploadService::upload($value, "sub-categories/$subCategory->id/");
                $dataFile['name'] = $value->getClientOriginalName();
                $dataFile['path'] = $path;
                $dataFile['type'] = $type;
                $dataFile['sub_category_id'] = $subCategory->id;


                $this->fileRepository->store($dataFile);
            }


        }

        return $subCategory;
    }

    public function edit($id)
    {
        return $this->subCategorryRepository->edit($id);
    }

    public function update($date, $id)
    {
        return $this->subCategorryRepository->update($date->toArray(), $id);
    }


}
