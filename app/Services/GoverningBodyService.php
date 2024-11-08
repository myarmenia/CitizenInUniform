<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\GoverningBodyInterface;
use Illuminate\Http\Request;
use Storage;

class GoverningBodyService
{
    public function __construct(
        protected GoverningBodyInterface $governingBodyRepository
    ) {
    }

    public function index(){
        return $this->governingBodyRepository->index();
    }

    public function getItem($id)
    {
        return $this->governingBodyRepository->getItem($id);
    }


}
