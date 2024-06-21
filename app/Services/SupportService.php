<?php

namespace App\Services;

use App\Http\Resources\RepliesSupportResource;
use App\Http\Resources\SupportResource;
use App\Repositories\Member\SupportRepositoryInterface;
use App\Repositories\PaginationInterface;

class SupportService
{
    private $repository;

    public function __construct(SupportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSupportProducerByStatus(
        int $page = 1,
        int $totalPerPage  = 15,
        string $status = null
    ): PaginationInterface {
        return $this->repository->getSupportProducerByStatus(
            page: $page,
            totalPerPage: $totalPerPage,
            status: $status
        );
    }

    public function getSupport(string $id)
    {
        return $this->repository->findById($id);
    }

}
