<?php

namespace App\Http\Controllers\Api\MessageCategories;

use App\DTO\MessageCategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageCategoryRequest;
use App\Http\Resources\MessageCategoryResource;
use App\Http\Resources\Mobile\MMessageCategoryResource;
use App\Models\MessageCategory;
use App\Services\MessageCategoryService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class MessageCategoryController extends BaseController
{
    use Paginator;
    /**
     * Display a listing of the resource.
     *
     */
    public function __construct(protected MessageCategoryService $service){


    }
    public function index(Request $request)
    {


        $page = request()->page ?? 1;
        $perPage = 2;

            $data = $this->service->index();
            $data = MessageCategoryResource::collection($data);

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
    public function store(MessageCategoryRequest $request)
    {

        $data = $this->service->store(MessageCategoryDto::fromMessageCategoryDto($request));
        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->service->show($id);

        $faqCategorySubcategory = new MessageCategoryResource($data );
        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MessageCategoryRequest $request, string $id)
    {

            $data = $this->service->update(MessageCategoryDto::fromMessageCategoryDto($request), $id);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function mobileIndex()
    {
        $data = MessageCategory::all();

        $data = MMessageCategoryResource::collection($data);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
