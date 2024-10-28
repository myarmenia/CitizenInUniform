<?php
namespace App\Repositories;

use App\DTO\FaqCategoryDto;

use App\Interfaces\FaqCategorySubcategoryRepositoryInterface;
use App\Models\FAQSubCategory;
use App\Services\FaqCategorySubcategory;

class FaqCategorySubcategoryRepository implements FaqCategorySubcategoryRepositoryInterface
{
    public function index(){
       return FAQSubCategory::query()->get();

    }
    public function store($data){

        return FAQSubCategory::create($data);

    }
    public function update(){

    }
}
