<?php
namespace App\Repositories;

use App\DTO\FaqCategoryDto;
use App\Helpers\MyHelper;
use App\Interfaces\FaqCategorySubcategoryRepositoryInterface;
use App\Models\FAQSubCategory;
use App\Services\FaqCategorySubcategory;

class FaqCategorySubcategoryRepository implements FaqCategorySubcategoryRepositoryInterface
{
    public function index(){

       return FAQSubCategory::query()->get();

    }
    public function store($data){

        $data=MyHelper::addActionPermission($data);
        return FAQSubCategory::create($data);

    }
    public function show($id){
        return FAQSubCategory::find($id);
    }
    public function update($data,$id){


        $faqCategorySubcategory = FAQSubCategory::find($id);

        return  $faqCategorySubcategory ? $faqCategorySubcategory->update($data) : false;

    }
}
