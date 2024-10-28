<?php

namespace App\Interfaces;

use App\DTO\FaqCategoryDto;

interface  FaqCategorySubcategoryRepositoryInterface {

    public function store($data);

    public function update();
}
