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


// Route::get('/', function () {
//     return redirect()->route('login');
// });
// Route::get('/', function () {
//     return view('index');
// });
Route::get('/{any}',function(){
    return view('index');
})->where('any',".*");


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['middleware' => ['auth']], function() {
//     Route::resource('roles', RoleController::class);
//     Route::resource('users', UserController::class);

//     // Route::resource('category', CategoryController::class);
//     // Route::resource('sub-category', SubCategoryController::class);



//     Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');

// });


// Route::get('get-file', [FileUploadService::class, 'get_file'])->name('get-file');

