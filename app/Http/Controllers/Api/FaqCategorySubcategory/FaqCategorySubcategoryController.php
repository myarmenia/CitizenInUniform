<?php

namespace App\Http\Controllers\Api\FaqCategorySubcategory;

use App\DTO\FaqCategorySubcategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategorySubcategoryRequest;
use App\Http\Resources\FaqCategorySubcategoryResource;
use App\Models\FAQSubCategory;
use App\Services\FaqCategorySubcategoryService;
use Illuminate\Http\Request;

class FaqCategorySubcategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected FaqCategorySubcategoryService $service)
    {

    }
    public function index()
    {

            $data = $this->service->index();
            $data=FaqCategorySubcategoryResource::collection($data );

        return $data != null ? $this->sendResponse($data, 'cuccess') : $this->sendError('error');



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
    public function store(FaqCategorySubcategoryRequest $request)
    {

        $data = $this->service->store(FaqCategorySubcategoryDto::fromRequestDto($request));


        return $data != null ? $this->sendResponse($data, 'cuccess') : $this->sendError('error');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd($id);
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
}
