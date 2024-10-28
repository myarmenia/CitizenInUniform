<?php

namespace App\Interfaces;

interface  FaqCategorySubcategoryRepositoryInterface {
    
    public function index();

    public function store($data);

    public function update();
}
