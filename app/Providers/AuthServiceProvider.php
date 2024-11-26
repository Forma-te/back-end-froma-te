<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Ebook;
use App\Models\Sale;
use App\Models\User;
use App\Policies\CoursePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Gate::policy(Product::class, CoursePolicy::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('owner-course', function (User $user, Product $course) {
            return $course->user_id ===  $user->id;
        });

        Gate::define('owner-ebook', function (User $user, Product $ebook) {
            return $ebook->user_id === $user->id;
        });

        Gate::define('owner-file', function (User $user, Product $file) {
            return $file->user_id === $user->id;
        });

        Gate::define('owner-sale', function (User $user, Sale $sale) {
            return $sale->producer_id === $user->id;
        });

        // Verifica se o usuário está tentando modificar seu próprio registro
        Gate::define('owner-user', function (User $currentUser, User $userToUpdate) {
            return $currentUser->id === $userToUpdate->id;
        });
    }
}
