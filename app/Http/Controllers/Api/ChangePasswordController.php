<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function index(ChangePasswordRequest $request){
        // dd($request->all());
    }
}
