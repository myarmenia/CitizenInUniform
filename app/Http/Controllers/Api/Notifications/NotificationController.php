<?php

namespace App\Http\Controllers\Api\Notifications;

use App\DTO\FcmNotificationDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FcmNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Services\FcmNotificationService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    use Paginator;
    public function __construct(protected FcmNotificationService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = request()->page ?? 1;
        $perPage = 10;

        $data = $this->service->index();

        $data = NotificationResource::collection($data);
        $data = $this->arrayPaginator($data, $request, $perPage);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FcmNotificationRequest $request)
    {

        $data = $this->service->store(FcmNotificationDto::fromFcmNotificationDto($request));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

}
