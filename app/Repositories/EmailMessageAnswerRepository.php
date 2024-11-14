<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\EmailMessageAnswerInterface;
use App\Models\EmailMessageAnswer;
use App\Models\EmailMessages;


class EmailMessageAnswerRepository implements EmailMessageAnswerInterface
{

    public function store($data): EmailMessageAnswer
    {

        return EmailMessageAnswer::create($data);
    }


}
