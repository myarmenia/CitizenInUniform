<?php

namespace App\Http\Controllers\Api\Reports;

use App\DTO\ReportDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    public function __construct(protected ReportService $service)
    {

    }
    public function report(Request $request){

        $data = array_filter($request->all(), fn($value) => $value !== null);

        $data = $this->service->report(ReportDto::fromReportDto($data));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
