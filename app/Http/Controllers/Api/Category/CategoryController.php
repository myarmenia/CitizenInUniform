<?php

namespace App\Http\Controllers\Api\Category;

use App\DTO\CategoryDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\Mobile\MCategoyResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    use Paginator;
    public function __construct(protected CategoryService $service)
    {
        $this->middleware('check_action_permission_for_category:' . Category::class, ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = request()->page ?? 1;
        $perPage = 10;

        $data = $this->service->index();

        $data = CategoryResource::collection($data);
        $data = $this->arrayPaginator($data, $request, $perPage);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        $data = $this->service->store(CategoryDto::fromCategoryDto($request));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {

        $data = $this->service->getItem($id);
        $data = $data != null ? CategoryResource::make($data) : null;

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {

        $data = $this->service->update(CategoryDto::fromCategoryDto($request), $id);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }


    public function activeCategories()
    {
        $data = $this->service->activeCategories();

        $data = CategoryResource::collection($data);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    public function mobileCategories()
    {
        $data = $this->service->activeCategories();

        $data = MCategoyResource::collection($data);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
