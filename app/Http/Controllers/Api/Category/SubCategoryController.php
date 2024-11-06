<?php

namespace App\Http\Controllers\Api\Category;

use App\DTO\SubCategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\AllSubCategoryResource;
use App\Http\Resources\SubCategoryResource;
use App\Services\SubCategoryService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class SubCategoryController extends BaseController
{
    use Paginator;
    public function __construct(protected SubCategoryService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = request()->page ?? 1;
        $perPage = 10;

        $data = $this->service->index();
        $data = AllSubCategoryResource::collection($data);

        $data = $this->arrayPaginator($data, $request, $perPage);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }


    public function store(SubCategoryRequest $request)
    {

        $data = $this->service->store(SubCategoryDto::fromSubCategoryDto($request));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->service->getItem($id);
        $data = $data != null ? SubCategoryResource::make($data) : null;

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, string $id)
    {

        $data = $this->service->update(SubCategoryDto::fromSubCategoryDto($request), $id);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    public function mobileSingleSubCategory($id){

        $data = $this->service->getActiveItem($id);
        $data = $data != null ? SubCategoryResource::make($data) : null;

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }


}
