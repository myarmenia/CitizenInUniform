<?php
namespace App\Repositories;

use App\DTO\FaqCategoryDto;
use App\Interfaces\FaqCategoryRepositoryInterface;
use App\Models\FAQCategory;

class FaqCategoryRepository implements FaqCategoryRepositoryInterface
{

    public function index(){

        return FAQCategory::all();

    }
    public function store($data){

        return FaqCategory::create($data);

    }
    public function update(){

    }
    public function activeFaqCategory(){

        return FAQCategory::where('status',1)->with('f_a_q_sub_categories')->get();
    }
}
