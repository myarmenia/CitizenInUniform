<?php

namespace App\Providers;


use App\Interfaces\CategoryInterface;
use App\Interfaces\FaqCategoryRepositoryInterface;
use App\Interfaces\FaqCategorySubcategoryRepositoryInterface;
use App\Interfaces\FcmNotificationInterface;
use App\Interfaces\FileInterface;
use App\Interfaces\MobileUserInterface;
use App\Interfaces\SubCategoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\FaqCategoryRepository;
use App\Repositories\FaqCategorySubcategoryRepository;
use App\Repositories\FcmNotificationRepository;
use App\Repositories\FileRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MobileUserRepository;
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

        $this->app->bind(MobileUserInterface::class, MobileUserRepository::class);
        $this->app->bind(FcmNotificationInterface::class, FcmNotificationRepository::class);


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
