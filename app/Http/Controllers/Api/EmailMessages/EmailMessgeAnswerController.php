<?php

namespace App\Http\Controllers\Api\EmailMessages;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailMessageAnswerRequest;
use App\Services\EmailMessageService;
use Illuminate\Http\Request;

class EmailMessgeAnswerController extends BaseController
{
    public function __construct(protected EmailMessageService $service)
    {

    }
    public function __invoke(EmailMessageAnswerRequest $request){

        $data = $this->service->storeAnswer($request->all());
        

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
