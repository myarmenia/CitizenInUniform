<?php

namespace App\Services;

use App\DTO\FaqCategoryDto;
use App\Interfaces\FaqCategoryRepositoryInterface;

class FaqCategoryService{



    public function __construct(protected FaqCategoryRepositoryInterface $faqCategoryRepository){

    }
    public function storeFaqCategory( $data){

        return $this->faqCategoryRepository->store( $data->toArray());

    }


}
