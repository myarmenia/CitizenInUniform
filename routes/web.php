<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\DeleteItemController;
use App\Http\Controllers\GetCalendarDataController;
use App\Http\Controllers\GetDayReservationsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Route;



Route::get('/{any}',function(){
    return view('index');
})->where('any',".*");

// Auth::routes();


