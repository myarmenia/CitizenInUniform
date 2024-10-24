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

    public function store($date)
    {
        return $this->categorryRepository->store($date->toArray());
    }

}
