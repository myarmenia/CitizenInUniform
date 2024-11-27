<?php

namespace App\Services;

use App\DTO\FaqCategoryDto;
use App\Interfaces\FaqCategoryRepositoryInterface;

class FaqCategoryService{



    public function __construct(protected FaqCategoryRepositoryInterface $faqCategoryRepository){

    }
    public function index(){
        return $this->faqCategoryRepository->index();
    }
    public function storeFaqCategory( $data){

        return $this->faqCategoryRepository->store( $data->toArray());

    }
    public function getActiveFaqCategories(){

        return $this->faqCategoryRepository->activeFaqCategory();
    }


}
