<?php

namespace App\Providers;


use App\Interfaces\CategoryInterface;
use App\Interfaces\FaqCategoryRepositoryInterface;
use App\Interfaces\SubCategoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\FaqCategoryRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\SubCategoryRepository;
use App\Repositories\UserRepository;
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
