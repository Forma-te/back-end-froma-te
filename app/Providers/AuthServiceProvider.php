<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Ebook;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('owner-course', function (User $user, Course $course) {
            return $course->user_id == $user->id;
        });

        Gate::define('owner-ebook', function (User $user, Ebook $ebook) {
            return $ebook->user_id == $user->id;
        });
    }
}
