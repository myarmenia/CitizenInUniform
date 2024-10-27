<?php
namespace App\Repositories;

use App\DTO\FaqCategoryDto;
use App\Interfaces\FaqCategoryRepositoryInterface;
use App\Models\FAQCategory;

class FaqCategoryRepository implements FaqCategoryRepositoryInterface
{
    public function store($data){
        // dd($data);
        return FAQCategory::create(FaqCategoryDto::toArray());

    }
    public function update(){

    }
}
