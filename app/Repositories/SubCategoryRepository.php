<?php

namespace App\Repositories;

use App\Interfaces\SubCategoryInterface;
use App\Models\SubCategory;


class SubCategoryRepository implements SubCategoryInterface
{
    public function index(){
        return SubCategory::all();
    }

    public function store($data): SubCategory
    {
        return SubCategory::create($data);
    }
    public function edit(string $id){
        return SubCategory::find($id);
    }

    public function update($data, string $id){

        $category = SubCategory::find($id);
        return $category ? $category->update($data) : false;
    }


    // public function destroy(string $id){
    //     //
    // }

}
