<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

use App\Repositories\Course\{
    CourseRepository,
    CourseRepositoryInterface
};
use App\Repositories\Ebook\EbookRepository;
use App\Repositories\Ebook\EbookRepositoryInterface;
use App\Repositories\Lesson\LessonRepository;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\Module\ModuleRepository;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\Statistics\{
    StatisticsRepository,
    StatisticsRepositoryInterface
};
use App\Repositories\Support\{
    ReplySupportRepository,
    ReplySupportRepositoryInterface,
    SupportRepository
};
use App\Repositories\Support\{
    SupportRepositoryInterface
};
use App\Repositories\User\{
    UserRepository,
    UserRepositoryInterface};
use Illuminate\Support\{
    ServiceProvider
};

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

        $this->app->singleton(
            ModuleRepositoryInterface::class,
            ModuleRepository::class,
        );

        $this->app->singleton(
            LessonRepositoryInterface::class,
            LessonRepository::class,
        );

        $this->app->singleton(
            EbookRepositoryInterface::class,
            EbookRepository::class,
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
