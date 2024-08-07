<?php

namespace App\Repositories\Statistics;

interface StatisticsRepositoryInterface
{
    public function getTotalUsers(): int;
    public function getTotalSupports(): int;
}
