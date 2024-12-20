<?php

namespace App\Http\Controllers;


use App\DTO\FaqCategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\FaqCategoryRequest;
use App\Http\Resources\FaqCategoryResource;
use App\Http\Resources\Mobile\MFaqCategoryResource;
use App\Models\FAQCategory;
use App\Services\FaqCategoryService;
use App\Traits\Paginator;

use Illuminate\Http\Request;

class FaqCategoryController extends BaseController
{
    use Paginator;



    public function __construct( protected FaqCategoryService $faqCategoryService){
        $this->middleware('check_action_permission:' . FAQCategory::class, ['only' => ['edit']]);

    }
    public function index(Request $request){
        $page = request()->page ?? 1;
        $perPage = 10;


        $data = $this->faqCategoryService->index();

        $data = FaqCategoryResource::collection($data );
        $data = $this->arrayPaginator($data, $request, $perPage);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    public function store(FaqCategoryRequest $request){

        $data = $this->faqCategoryService->storeFaqCategory(FaqCategoryDTO::fromFaqCategoryDto($request));

        return response()->json("success");
    }
    public function edit($id){

        $faqCategory = FAQCategory::find($id);

        return response()->json(["faqCategory"=>$faqCategory],200);
    }
    public function update(FaqCategoryRequest $request,$id){


        $faqCategory = FAQCategory::find($id);

        $faqCategory->title=$request->title;

        $faqCategory->save();
    }

    public function all(){

        $data = FAQCategory::where('status',1)->get();

        return response()->json(['faqCategories'=>$data],200);

    }
    public function mobile_faqCategory(){
        $data = $this->faqCategoryService->getActiveFaqCategories();


        return $data != null ? $this->sendResponse(MFaqCategoryResource::collection($data), 'success') : $this->sendError('error');


    }
}
