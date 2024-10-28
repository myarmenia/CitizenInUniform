<?php

namespace App\Interfaces;

use App\DTO\FaqCategoryDto;

interface  FaqCategoryRepositoryInterface {

    public function store($data);

    public function update();
}
