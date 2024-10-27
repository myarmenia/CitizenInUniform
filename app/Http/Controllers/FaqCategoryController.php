<?php

namespace App\Http\Controllers;

use App\DTO\FaqCategoryDto;
use App\Services\FaqCategoryService;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{


    public function __construct( protected FaqCategoryService $faqCategoryService){

    }

    public function store(Request $request){

        $data = $this->faqCategoryService->storeFaqCategory(FaqCategoryDto::fromFaqCategoryDto($request));

        // return response()->json();
    }
}
