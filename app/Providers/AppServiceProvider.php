<?php

namespace App\Providers;


use App\Interfaces\CategoryInterface;
use App\Interfaces\EmailMessageAnswerInterface;
use App\Interfaces\EmailMessageInterface;
use App\Interfaces\FaqCategoryRepositoryInterface;
use App\Interfaces\FaqCategorySubcategoryRepositoryInterface;
use App\Interfaces\FcmNotificationInterface;
use App\Interfaces\FileInterface;
use App\Interfaces\GoverningBodyInterface;
use App\Interfaces\MobileUserInterface;
use App\Interfaces\SettingInterface;
use App\Interfaces\SubCategoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\EmailMessageAnswerRepository;
use App\Repositories\EmailMessageRepository;
use App\Repositories\FaqCategoryRepository;
use App\Repositories\FaqCategorySubcategoryRepository;
use App\Repositories\FcmNotificationRepository;
use App\Repositories\FileRepository;
use App\Repositories\GoverningBoryRepository;
use App\Repositories\MobileUserRepository;
use App\Repositories\SettingRepository;
use App\Repositories\SubCategoryRepository;
use App\Repositories\UserRepository;
use App\Services\FaqCategorySubcategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(SubCategoryInterface::class, SubCategoryRepository::class);
        $this->app->bind(FaqCategoryRepositoryInterface::class, FaqCategoryRepository::class);
        $this->app->bind(FaqCategorySubcategoryRepositoryInterface::class, FaqCategorySubcategoryRepository::class);
        $this->app->bind(FileInterface::class, FileRepository::class);
        $this->app->bind(SettingInterface::class, SettingRepository::class);

        $this->app->bind(MobileUserInterface::class, MobileUserRepository::class);
        $this->app->bind(FcmNotificationInterface::class, FcmNotificationRepository::class);
        $this->app->bind(GoverningBodyInterface::class, GoverningBoryRepository::class);
        $this->app->bind(EmailMessageInterface::class, EmailMessageRepository::class);
        $this->app->bind(EmailMessageAnswerInterface::class, EmailMessageAnswerRepository::class);


        // ====================== hiny ================================

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
