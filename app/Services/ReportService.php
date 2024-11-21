<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use Illuminate\Http\Request;
use Storage;

class ReportService
{
    public function __construct(
        protected CategoryInterface $categorryRepository
    ) {
    }

    public function report($data)
    {

        dd($data->governing_body_id);

        return $this->categorryRepository->index();
    }


    public function emailMessages($data){

        if(isset)

    }

    public function chatMessages($data)
    {

    }



}
