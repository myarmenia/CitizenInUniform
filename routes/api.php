<?php

use App\Http\Controllers\Api\AllMessages\AllMessagesController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Category\SubCategoryController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\EmailMessages\EmailMessgeAnswerController;
use App\Http\Controllers\Api\EmailMessages\EmailMessgeController;
use App\Http\Controllers\Api\FaqCategorySubcategory\FaqCategorySubcategoryController;


use App\Http\Controllers\Api\GoverningBodies\GoverningBodyController;
use App\Http\Controllers\Api\Logs\LogController;
use App\Http\Controllers\Api\MessageCategories\MessageCategoryController;
use App\Http\Controllers\Api\Mobile\PhoneCallController;
use App\Http\Controllers\Api\Notifications\NotificationController;
use App\Http\Controllers\Api\Notifications\SendNotificationToUserController;
use App\Http\Controllers\Api\Mobile\MobileUserController;
use App\Http\Controllers\Api\Reports\ReportController;
use App\Http\Controllers\Api\Settings\SettingController;
use App\Http\Controllers\Api\UserLoginLogsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\ConfirmPasswordChangesController;
use App\Http\Controllers\DeleteItemController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\UserLoginLog;
use Illuminate\Support\Facades\Route;



// Route::post('send-notification', SendNotificationToUserController::class);


    Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    // this url required for above route
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
    // after email get form reset password form and  make password.update
    Route::put('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// ======================== Mobile ======================================
Route::group(['prefix' => 'mobile'], function ($router) {
    Route::post('user-device', [MobileUserController::class, 'mobileUserDeviceStore']);

    Route::get('categories', [CategoryController::class, 'mobileCategories']);
    Route::get('governing-bodies', [GoverningBodyController::class, 'mobileIndex']);
    Route::get('message-categories', [MessageCategoryController::class, 'mobileIndex']);
    Route::get('message-categories-with-trashed', [MessageCategoryController::class, 'categoryWithTrashed']);

    Route::get('sub-category/{id}/show', [SubCategoryController::class, 'mobileSingleSubCategory']);
    Route::post('email-messages/store', [EmailMessgeController::class, 'store']);
    Route::post('phone-call/store', [PhoneCallController::class, 'store']);

    Route::get('faq-categories',[FaqCategoryController::class,'mobile_faqCategory']);

    Route::post('chat-messages-store', [EmailMessgeController::class, 'chatMessagesStore']);

});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout'])->name('logout');
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

    Route::group(['middleware'=>'jwt.auth'],function(){

        Route::group(['middleware' => ['role:super_admin|admin|content_manager']],function(){
            Route::apiResource('categories', CategoryController::class);
            Route::get('active-categories', [CategoryController::class, 'activeCategories']);
            Route::apiResource('sub-categories', SubCategoryController::class);

            Route::get('/list-faq-categories', [FaqCategoryController::class, 'index']);
            Route::post('/create-faq-category', [FaqCategoryController::class, 'store']);
            Route::get('/faq-categories/{id}/edit', [FaqCategoryController::class, 'edit']);
            Route::put('/faq-categories/{id}', [FaqCategoryController::class, 'update']);
            Route::get('/all-faq-categories', [FaqCategoryController::class, 'all']);
            Route::apiResource('faq-category-subcategory', FaqCategorySubcategoryController::class);

            Route::apiResource('governing-bodies', GoverningBodyController::class);
            Route::apiResource('notifications', NotificationController::class);

            Route::post('reports', [ReportController::class, 'report']);

            Route::get('delete-item/{tb_name}/{id}', [DeleteItemController::class, 'index'])->name('delete_item');
            Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');

            Route::apiResource('messages-categories', MessageCategoryController::class);

        });


        Route::group(['middleware' => ['role:super_admin|operatorPN|operatorMIP']],function(){
            Route::apiResource('email-messages', EmailMessgeController::class);
            Route::post('email-messages-answer/store', EmailMessgeAnswerController::class);
            Route::post('email-messages', [EmailMessgeController::class, 'index']);

            Route::get('get-messages-counts', AllMessagesController::class);

        });

        Route::group(['middleware' => ['role:super_admin|admin']], function () {
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
            Route::post('logs', LogController::class);
        });


        Route::get('settings', SettingController::class);
        Route::get('all-roles', [RoleController::class, 'all']);
        Route::get('all-roles-list', [RoleController::class, 'allRoleList']);
        Route::post('change-password',[ChangePasswordController::class,'index']);
        Route::get('get-auth-user-roles', [RoleController::class, 'getAuthUserRoles']);


        Route::get('delete-item/{tb_name}/{id}', [DeleteItemController::class, 'index'])->name('delete_item');
        Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');
        Route::get('user-login-logs',UserLoginLogsController::class);


    });


});
