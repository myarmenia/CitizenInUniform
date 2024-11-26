<?php

namespace App\Http\Controllers\Api\Logs;

use App\DTO\LogDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Models\Log;
use App\Services\LogService;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class LogController extends BaseController
{
    use Paginator;

    public function __construct(protected LogService $service)
    {

    }
    public function __invoke(Request $request)
    {
        $page = request()->page ?? 1;
        $perPage = 3;

        // $data = array_filter($request->all(), fn($value) => $value !== null);

        // $data = $this->service->logs(LogDto::fromLogDto($request->all()));
        $data = $this->service->logs();


        $data = LogResource::collection($data);
        $data = $this->arrayPaginator($data, $request, $perPage);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
