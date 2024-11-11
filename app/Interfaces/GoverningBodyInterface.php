<?php

namespace App\Interfaces;

interface GoverningBodyInterface
{
    public function index();
    public function getItem(string $id);
    public function update($data, string $id);


}
