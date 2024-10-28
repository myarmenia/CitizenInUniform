<?php

namespace App\Interfaces;

interface SubCategoryInterface
{
    public function index();
    public function store($data);
    public function edit(string $id);
    public function update($data, string $id);
    // public function destroy(string $id);
}
