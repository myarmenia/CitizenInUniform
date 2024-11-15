<?php

namespace App\Interfaces;

interface EmailMessageInterface
{
    public function index();
    public function store($data);
    public function getItem(string $id);
    
}
