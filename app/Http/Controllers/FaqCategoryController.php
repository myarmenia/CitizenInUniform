<?php

namespace App\Http\Controllers;


use App\DTO\FaqCategoryDto;
use App\Http\Requests\FaqCategoryRequest;
use App\Http\Resources\FaqCategoryResource;
use App\Models\FAQCategory;
use App\Services\FaqCategoryService;

use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{



    public function __construct( protected FaqCategoryService $faqCategoryService){

    }
    public function index(){



        $data = $this->faqCategoryService->index();

        $data = FaqCategoryResource::collection($data );
        // dd($data->paginator(2));

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
        // $faqCategory->status=$request->status;
        $faqCategory->save();
    }

    public function destroy($id){

        $faq_category = FaqCategory::findOrFail($id);
        $faq_category->delete();


    }
}
