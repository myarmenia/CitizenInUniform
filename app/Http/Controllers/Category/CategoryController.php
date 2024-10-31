<?php

namespace App\Http\Controllers\Category;

use App\DTO\CategoryDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = $this->service->index();

        return view("category.index", compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("category.create");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $this->service->store(CategoryDto::fromCategoryDto($request));

        return redirect()->route("category.index");

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


        $data = $this->service->edit($id);

        return view("category.edit", compact('data'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {

        $data = $this->service->update(CategoryDto::fromCategoryDto($request), $id);

        return redirect()->route("category.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
