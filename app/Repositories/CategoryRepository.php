<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;


class CategoryRepository implements CategoryInterface
{
    public function index(){
        return Category::all();
    }

    public function store($data): Category
    {
        return Category::create($data);
    }
    // public function edit(string $id){
    //     //
    // }
    // public function update($data, string $id){
    //     //
    // }
    // public function destroy(string $id){
    //     //
    // }

}
