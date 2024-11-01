<?php

use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Category\SubCategoryController;
use App\Http\Controllers\Api\FaqCategorySubcategory\FaqCategorySubcategoryController;

use App\Http\Controllers\Api\Mobile\MobileUserController;
use App\Http\Controllers\Api\Turnstile\EntryCodeController;
use App\Http\Controllers\Api\Turnstile\EntryExitSystemController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\DeleteItemController;
use App\Http\Controllers\FaqCategoryController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource('categories', CategoryController::class);
Route::get('active-categories', [CategoryController::class, 'activeCategories']);
Route::apiResource('sub-categories', SubCategoryController::class);

// ======================== Mobile ======================================
Route::group(['prefix' => 'mobile'], function ($router) {
    Route::post('user-device', [MobileUserController::class, 'mobileUserDeviceStore']);

    Route::get('categories', [CategoryController::class, 'mobileCategories']);
    Route::get('sub-category/{id}/show', [SubCategoryController::class, 'mobileSingleSubCategory']);


});


Route::get('/all-faq-categories',[FaqCategoryController::class,'all']);
Route::get('/list-faq-categories',[FaqCategoryController::class,'index']);
Route::post('/create-faq-category',[FaqCategoryController::class,'store']);
Route::get('/faq-categories/{id}/edit',[FaqCategoryController::class,'edit']);
Route::put('/faq-categories/{id}',[FaqCategoryController::class,'update']);
Route::delete('/faq-categories/{id}',[FaqCategoryController::class,'destroy']);

Route::apiResource('faq-category-subcategory',FaqCategorySubcategoryController::class);

Route::get('delete-item/{tb_name}/{id}', [DeleteItemController::class, 'index'])->name('delete_item');
Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');


