<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

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
        return $this->categorryRepository->store($data->toArray());
    }

    public function edit($id)
    {
        return $this->categorryRepository->edit($id);
    }

    public function update($data, $id)
    {
        return $this->categorryRepository->update($data->toArray(), $id);
    }
    public function activeCategories()
    {
        return $this->categorryRepository->activeCategories();
    }


}
