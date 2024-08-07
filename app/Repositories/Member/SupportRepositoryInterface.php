<?php

namespace App\Repositories\Member;

use App\Repositories\PaginationInterface;

interface SupportRepositoryInterface
{
    public function getSupportProducerByStatus(int $page = 1, int $totalPerPage  = 15, string $status): PaginationInterface;
    public function findById(string $id): object|null;
}
