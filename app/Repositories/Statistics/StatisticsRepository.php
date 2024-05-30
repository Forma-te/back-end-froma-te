<?php

namespace App\Repositories\Statistics;

use App\Models\Support;
use App\Models\User;
use App\Repositories\Statistics\StatisticsRepositoryInterface;

class StatisticsRepository implements StatisticsRepositoryInterface
{
    public function getTotalUsers(): int
    {
        return User::count();
    }

    public function getTotalSupports(): int
    {
        return Support::where('status', 'P')->count();
    }

}
