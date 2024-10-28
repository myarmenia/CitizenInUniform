<?php

namespace App\Http\Controllers\Api\Category;

use App\DTO\CategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = $this->service->index();

        return $data != null ? $this->sendResponse($data, 'cuccess') : $this->sendError('error');


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        $data = $this->service->store(CategoryDto::fromCategoryDto($request));

        return $data != null ? $this->sendResponse($data, 'cuccess') : $this->sendError('error');

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {


        $data = $this->service->edit($id);

        return $data != null ? $this->sendResponse($data, 'cuccess') : $this->sendError('error');


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {

        $data = $this->service->update(CategoryDto::fromCategoryDto($request), $id);

        return $data != null ? $this->sendResponse($data, 'cuccess') : $this->sendError('error');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
