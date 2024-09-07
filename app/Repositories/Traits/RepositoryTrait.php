<?php

namespace App\Repositories\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait RepositoryTrait
{
    private function getUserAuth(): User
    {
        return Auth::user();

    }
}
