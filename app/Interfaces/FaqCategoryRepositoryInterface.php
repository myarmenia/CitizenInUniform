<?php

namespace App\Interfaces;

use App\DTO\FaqCategoryDto;

interface  FaqCategoryRepositoryInterface {
    public function index();
    public function store($data);

    public function update();
    public function activeFaqCategory();
}
