<?php

namespace App\Providers;

use App\Events\SaleCreated;
use App\Listeners\SendSaleNotification;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Bank\BankRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

use App\Repositories\Course\{
    CourseRepository,
    CourseRepositoryInterface
};
use App\Repositories\Ebook\EbookRepository;
use App\Repositories\Ebook\EbookRepositoryInterface;
use App\Repositories\EbookContent\EbookContentRepository;
use App\Repositories\EbookContent\EbookContentRepositoryInterface;
use App\Repositories\Lesson\LessonRepository;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\Module\ModuleRepository;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\Sale\SaleRepository;
use App\Repositories\Sale\SaleRepositoryInterface;
use App\Repositories\Statistics\{
    StatisticsRepository,
    StatisticsRepositoryInterface
};
use App\Repositories\Support\{
    ReplySupportRepository,
    ReplySupportRepositoryInterface,
};
use App\Repositories\Member\{
    MemberRepository,
    MemberRepositoryInterface,
    SupportRepositoryInterface,
    SupportRepository
};
use App\Repositories\User\{
    UserRepository,
    UserRepositoryInterface};
use Illuminate\Support\{
    ServiceProvider
};
use Illuminate\Support\Facades\Event;

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

        $this->app->singleton(
            EbookContentRepositoryInterface::class,
            EbookContentRepository::class,
        );

        $this->app->singleton(
            BankRepositoryInterface::class,
            BankRepository::class,
        );

        $this->app->singleton(
            SaleRepositoryInterface::class,
            SaleRepository::class,
        );

        $this->app->singleton(
            MemberRepositoryInterface::class,
            MemberRepository::class,
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            SaleCreated::class,
            SendSaleNotification::class,
        );

    }
}
