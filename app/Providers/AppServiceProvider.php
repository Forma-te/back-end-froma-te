<?php

namespace App\Providers;

use App\Models\Plan;
use App\Observers\PlanObserver;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Eloquent\{
    CategoryRepository,
    CourseRepository,
    ReplySupportRepository,
    StatisticsRepository,
    SupportRepository,
    UserRepository
};

use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Statistics\StatisticsRepositoryInterface;
use App\Repositories\Support\ReplySupportRepositoryInterface;
use App\Repositories\Support\SupportRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->singleton(
            SupportRepositoryInterface::class,
            SupportRepository::class,
        );

        $this->app->singleton(
            ReplySupportRepositoryInterface::class,
            ReplySupportRepository::class,
        );

        $this->app->singleton(
            StatisticsRepositoryInterface::class,
            StatisticsRepository::class,
        );

        $this->app->singleton(
            CourseRepositoryInterface::class,
            CourseRepository::class,
        );

        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class,
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Plan::observe(PlanObserver::class);
    }
}
