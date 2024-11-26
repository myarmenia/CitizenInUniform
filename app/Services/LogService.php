<?php

namespace App\Services;


use App\Interfaces\LogInterface;

class LogService
{
    public function __construct(
        protected LogInterface $logRepository
    ) {
    }

    public function logs()
    {
        return $this->logRepository->all();
    }



}
