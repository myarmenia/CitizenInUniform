<?php

use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Category\SubCategoryController;
use App\Http\Controllers\Api\FaqCategorySubcategory\FaqCategorySubcategoryController;

use App\Http\Controllers\Api\Notifications\SendNotificationToUserController;
use App\Http\Controllers\Api\Turnstile\EntryCodeController;
use App\Http\Controllers\Api\Turnstile\EntryExitSystemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\DeleteItemController;
use App\Http\Controllers\FaqCategoryController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories/store', [CategoryController::class, 'store']);
// Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
// Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::apiResource('categories', CategoryController::class);
Route::get('active-categories', [CategoryController::class, 'activeCategories']);
Route::apiResource('sub-categories', SubCategoryController::class);
Route::post('send-notification', SendNotificationToUserController::class);



// ======================== turnstile Турникет ======================================
Route::group(['prefix' => 'turnstile'], function ($router) {

    // Route::post('entry-code/store', [EntryCodeController::class, 'store']); // karogh e petq ga

    // Route::post('ees', EntryExitSystemController::class);  //  Entry/Exit System
    // Route::post('active-qrs', ActiveQrsController::class);
    // Route::post('qr-black-list', QrBlackListController::class);

});


Route::post('/create-faq-category',[FaqCategoryController::class,'store']);
Route::get('/faq-categories/{id}/edit',[FaqCategoryController::class,'edit']);
Route::put('/faq-categories/{id}',[FaqCategoryController::class,'update']);
Route::delete('/faq-categories/{id}',[FaqCategoryController::class,'destroy']);

Route::apiResource('faq-category-subcategory',FaqCategorySubcategoryController::class);

Route::get('delete-item/{tb_name}/{id}', [DeleteItemController::class, 'index'])->name('delete_item');
Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');



Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

    Route::get('/list-faq-categories',[FaqCategoryController::class,'index']);
    Route::group(['middleware'=>'auth:api'],function(){


    });

        Route::get('/all-faq-categories',[FaqCategoryController::class,'all']);




});
