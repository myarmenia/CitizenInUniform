<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Interfaces\SettingInterface;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    public function __construct(protected SettingInterface $settingRepository )
    {

    }
    public function __invoke(){
        $data = $this->settingRepository->get();

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}
