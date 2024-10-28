<?php

namespace App\Interfaces;

use App\DTO\FaqCategoryDto;

interface  FaqCategoryRepositoryInterface {

    public function store($faqCategoryDto);

    public function update();
}
