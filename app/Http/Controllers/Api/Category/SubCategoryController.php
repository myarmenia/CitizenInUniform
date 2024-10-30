<?php

namespace App\Http\Controllers\Api\Category;

use App\DTO\SubCategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Services\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryController extends BaseController
{
    public function __construct(protected SubCategoryService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->index();

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $categories = $this->service->create();

    //     return view("sub-category.create", compact('categories'));
    // }

    /**
     * Store a newly created resource in storage.
     */
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
        $data = $this->service->edit($id);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
