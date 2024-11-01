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

    public function index()
    {
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

        if ($data->files != null && $subCategory != null) {
            $files = $data->files;

            $this->addFiles($files, $subCategory->id);

        }

        return $subCategory;
    }

    public function getItem($id)
    {
        return $this->subCategorryRepository->getItem($id);
    }

    public function update($data, $id)
    {

        $subCategory = $this->subCategorryRepository->update($data->toArray(), $id);

        if ($data->files != null && $subCategory) {
            $files = $data->files;

            $this->addFiles($files, $id);

        }

        return $subCategory;
    }

    public function addFiles($files, $subCategoryId)
    {

        try {
            foreach ($files as $key => $value) {

                $type = !$value->getError() ? explode('/', $value->getMimeType())[0] : null;

                $path = FileUploadService::upload($value, "sub_categories/$subCategoryId");
                $dataFile['name'] = $value->getClientOriginalName();
                $dataFile['path'] = $path;
                $dataFile['type'] = $type;
                $dataFile['sub_category_id'] = $subCategoryId;


                $this->fileRepository->store($dataFile);
            }
            return true;

        } catch (\Throwable $th) {
            return false;
        }

    }

    public function getActiveItem($id)
    {
        return $this->subCategorryRepository->getActiveItem($id);
    }


}
