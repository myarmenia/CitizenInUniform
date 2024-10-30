<?php

namespace App\Http\Controllers\Api\FaqCategorySubcategory;

use App\DTO\FaqCategorySubcategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategorySubcategoryRequest;
use App\Http\Resources\FaqCategoryResource;
use App\Http\Resources\FaqCategorySubcategoryResource;
use App\Models\FAQCategory;
use App\Models\FAQSubCategory;
use App\Services\FaqCategorySubcategoryService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class FaqCategorySubcategoryController extends BaseController
{
    use Paginator;
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected FaqCategorySubcategoryService $service)
    {

    }
    public function index(Request $request)
    {

        $page = request()->page ?? 1;
        $perPage = 2;

            $data = $this->service->index();
            $data = FaqCategorySubcategoryResource::collection($data );
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

        $faqCategorySubcategory = $this->service->show($id);
        $faqCategorySubcategory = new FaqCategorySubcategoryResource($faqCategorySubcategory );

        $data['faqCategorySubcategory']=$faqCategorySubcategory;
        $data['faqCategory']=FaqCategoryResource::collection(FAQCategory::all());

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
    public function update(FaqCategorySubcategoryRequest $request, string $id)
    {

        $data = $this->service->update(FaqCategorySubcategoryDto::fromRequestDto($request), $id);

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
