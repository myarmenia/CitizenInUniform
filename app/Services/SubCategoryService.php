<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\SubCategoryInterface;

class SubCategoryService
{
    public function __construct(
        protected SubCategoryInterface $subCategorryRepository,
        protected CategoryInterface $categoryRepository

    ) {
    }

    public function index(){
        return $this->subCategorryRepository->index();
    }

    public function create()
    {
        return $this->categoryRepository->index();
    }

    public function store($date)
    {
        return $this->subCategorryRepository->store($date->toArray());
    }

    public function edit($id)
    {
        return $this->subCategorryRepository->edit($id);
    }

    // public function update($date, $id)
    // {
    //     return $this->subCategorryRepository->update($date->toArray(), $id);
    // }


}
