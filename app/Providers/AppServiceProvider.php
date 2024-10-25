<?php

namespace App\Providers;


use App\Interfaces\AttendanceSheetInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CheckEntryCodeInterface;
use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\CreateEntryCodeInterface;
use App\Interfaces\SubCategoryInterface;
use App\Repositories\AttendanceSheetRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EntryCodeRepository;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PersonRepository;
use App\Repositories\SubCategoryRepository;
use App\Repositories\TurnstileRepository;
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


        // ====================== hiny ================================
        $this->app->bind(CreateEntryCodeInterface::class, EntryCodeRepository::class);
        $this->app->bind(ClientIdFromTurnstileInterface::class, TurnstileRepository::class);
        $this->app->bind(CheckEntryCodeInterface::class, TurnstileRepository::class);
        $this->app->bind(AttendanceSheetInterface::class, AttendanceSheetRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
