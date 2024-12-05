<?php

namespace App\Services;


use App\Interfaces\GoverningBodyInterface;

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

    public function update($data, $id)
    {

        return $this->governingBodyRepository->update($data->toArray(), $id);
    }


}
