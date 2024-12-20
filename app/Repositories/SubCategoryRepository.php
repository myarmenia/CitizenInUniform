<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\SubCategoryInterface;
use App\Models\SubCategory;


class SubCategoryRepository implements SubCategoryInterface
{
    public function index(){
        return SubCategory::all();
    }

    public function store($data): SubCategory
    {
        $data = MyHelper::addActionPermission($data);
        
        return SubCategory::create($data);
    }
    public function getItem(string $id){
        return SubCategory::find($id);
    }

    public function update($data, string $id){

        $category = SubCategory::find($id);
        return $category ? $category->update($data) : false;
    }

    public function getActiveItem(string $id){
        return SubCategory::where('id', $id)->where('status', 1)->first();
    }




}
