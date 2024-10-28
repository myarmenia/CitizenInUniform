<?php
namespace App\Repositories;

use App\DTO\FaqCategoryDto;
use App\Interfaces\FaqCategoryRepositoryInterface;
use App\Models\FAQCategory;

class FaqCategoryRepository implements FaqCategoryRepositoryInterface
{
    public function store($faqCategoryDto){

        $faqCategory = new FaqCategory();
        $faqCategory->title = $faqCategoryDto->title;
        $faqCategory->save();
        return  $faqCategory;


    }
    public function update(){

    }
}
