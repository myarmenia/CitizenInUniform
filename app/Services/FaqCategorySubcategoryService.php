<?php

namespace App\Services;

use App\Interfaces\FaqCategorySubcategoryRepositoryInterface;

class FaqCategorySubcategoryService{



    public function __construct(protected FaqCategorySubcategoryRepositoryInterface $faqCategorySubcategoryRepository){

    }
    public function index(){

        return $this->faqCategorySubcategoryRepository->index();

    }
    public function store( $data){

        return $this->faqCategorySubcategoryRepository->store( $data->toArray());

    }
    public function show($id){
        return $this->faqCategorySubcategoryRepository->show( $id);

    }
    public function update($data,$id){
dd($data);
        return $this->faqCategorySubcategoryRepository->update($data->toArray(), $id);
    }


}
