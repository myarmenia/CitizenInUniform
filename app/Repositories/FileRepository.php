<?php

namespace App\Repositories;

use App\Interfaces\FileInterface;
use App\Models\File;


class FileRepository implements FileInterface
{
    // public function index(){
    //     return SubCategory::all();
    // }

    public function store($data): File
    {
        return File::create($data);
    }
    // public function edit(string $id){
    //     return SubCategory::find($id);
    // }

    // public function update($data, string $id){

    //     $category = SubCategory::find($id);
    //     return $category ? $category->update($data) : false;
    // }


    // public function destroy(string $id){
    //     //
    // }

}
