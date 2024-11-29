<?php

namespace App\Http\Controllers\Api\GoverningBodies;

use App\DTO\GoverningBodyInfoDto;
use App\Helpers\MyHelper;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\GoverningBodyInfoRequest;
use App\Http\Resources\GoverningBodyResource;
use App\Http\Resources\GoverningBodyWithInfoResource;
use App\Http\Resources\Mobile\MGoverningBodyResource;
use App\Services\GoverningBodyService;
use Illuminate\Http\Request;

class GoverningBodyController extends BaseController
{
    public function __construct(protected GoverningBodyService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->index();

        $data = GoverningBodyResource::collection($data);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->service->getItem($id);
        $data = $data != null ? GoverningBodyWithInfoResource::make($data) : null;

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(GoverningBodyInfoRequest $request, string $id)
    {

        $data = $this->service->update(GoverningBodyInfoDto::fromGoverningBodyDto($request), $id);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function mobileIndex()
    {
        $data = $this->service->index();

        $data = MGoverningBodyResource::collection($data);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

}
