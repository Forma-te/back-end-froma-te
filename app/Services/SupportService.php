<?php

namespace App\Services;

use App\Http\Resources\RepliesSupportResource;
use App\Http\Resources\SupportResource;
use App\Repositories\Member\SupportRepositoryInterface;

class SupportService
{
    private $repository;

    public function __construct(SupportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSupports(string $status = 'P')
    {
        return $this->repository->getByStatus($status);
        //return RepliesSupportResource::collection($supports);
    }

    public function getSupport(string $id)
    {
        return $this->repository->findById($id);
    }

}
