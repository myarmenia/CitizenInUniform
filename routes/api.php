<?php

use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Category\SubCategoryController;
use App\Http\Controllers\Api\FaqCategorySubcategory\FaqCategorySubcategoryController;

use App\Http\Controllers\Api\Turnstile\EntryCodeController;
use App\Http\Controllers\Api\Turnstile\EntryExitSystemController;
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
Route::apiResource('sub-categories', SubCategoryController::class);


// ======================== turnstile Турникет ======================================
Route::group(['prefix' => 'turnstile'], function ($router) {

    // Route::post('entry-code/store', [EntryCodeController::class, 'store']); // karogh e petq ga

    // Route::post('ees', EntryExitSystemController::class);  //  Entry/Exit System
    // Route::post('active-qrs', ActiveQrsController::class);
    // Route::post('qr-black-list', QrBlackListController::class);

});

Route::get('/list-faq-categories',[FaqCategoryController::class,'index']);
Route::post('/create-faq-category',[FaqCategoryController::class,'store']);
Route::get('/faq-categories/{id}/edit',[FaqCategoryController::class,'edit']);
Route::put('/faq-categories/{id}',[FaqCategoryController::class,'update']);
Route::delete('/faq-categories/{id}',[FaqCategoryController::class,'destroy']);

Route::apiResource('faq-category-subcategory',FaqCategorySubcategoryController::class);

Route::get('delete-item/{tb_name}/{id}', [DeleteItemController::class, 'index'])->name('delete_item');


