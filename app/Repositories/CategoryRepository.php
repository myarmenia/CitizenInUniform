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
    public function edit(string $id){
        return Category::find($id);
    }

    public function update($data, string $id){

        $category = Category::find($id);
        return $category ? $category->update($data) : false;
    }


    // public function destroy(string $id){
    //     //
    // }

}
