<?php

namespace App\Http\Controllers;

use App\DTO\FaqCategoryDto;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\FAQCategory;
use App\Services\FaqCategoryService;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{


    public function __construct( protected FaqCategoryService $faqCategoryService){

    }
    public function index(){

        $data=FAQCategory::query();
        $data = $data->latest()->get();

        return response()->json(['faqCategories'=>$data]);
    }

    public function store(FaqCategoryRequest $request){

        // $faqCategoryDTO = new FaqCategoryDTO($request->title);

        $data = $this->faqCategoryService->storeFaqCategory(FaqCategoryDTO::fromFaqCategoryDto($request));

        return response()->json("success");
    }
    public function edit($id){


        $faqCategory = FAQCategory::find($id);

        return response()->json(["faqCategory"=>$faqCategory],200);
    }
    public function update(Request $request,$id){

if($request->status==true){
    $request['status']=1;
}else{
    $request['status']=0;
}
// dd($request->all());
$faqCategory = FAQCategory::find($id);
        // $faqCategory = FAQCategory::where('id',$id)->first();
        // $faqCategory->update($request->all());
        $faqCategory->title=$request->title;
        $faqCategory->status=$request->status;
        $faqCategory->save();
    }

    public function destroy($id){

        $faq_category = FaqCategory::findOrFail($id);
        $faq_category->delete();

    }
}
