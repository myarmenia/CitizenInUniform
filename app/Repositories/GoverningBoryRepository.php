<?php

namespace App\Repositories;

use App\Interfaces\GoverningBodyInterface;
use App\Models\Category;
use App\Models\GoverningBody;


class GoverningBoryRepository implements GoverningBodyInterface
{
    public function index()
    {
        return GoverningBody::all();
    }

    public function getItem(string $id)
    {
        return GoverningBody::find($id);
    }



}
