<?php

namespace App\Http\Controllers\Api\EmailMessages;

use App\DTO\EmailMessageDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\EmailMessageRequest;
use App\Http\Resources\EmailMessageResource;
use App\Http\Resources\EmailSingleMessageResource;
use App\Models\Message;
use App\Services\EmailMessageService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class EmailMessgeController extends BaseController
{
    use Paginator;
    public function __construct(protected EmailMessageService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $page = request()->page ?? 1;
        $perPage = 3;

        $data = $this->service->index();

        $data = EmailMessageResource::collection($data);
        $data = $this->arrayPaginator($data, $request, $perPage);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailMessageRequest $request)
    {

        // dd($request->all());
        $data = $this->service->store(EmailMessageDto::fromEmailMessageDto($request));

        return $data != null ? $this->sendResponse([], 'success') : $this->sendError('error');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = $this->service->getItem($id);

        $data = $data != null ? EmailSingleMessageResource::make($data) : null;

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function chatMessagesStore(Request $request){
       
        $data = $this->service->chatMessageCount($request->id);

        return $data != null ? $this->sendResponse([], 'success') : $this->sendError('error');

    }

}
