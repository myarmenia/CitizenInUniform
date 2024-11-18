<?php
namespace App\Interfaces;



interface MessageCategoryInterface {
    public function index();

    public function store($data);
    public function show($id);
    public function update($data,$id);


}
