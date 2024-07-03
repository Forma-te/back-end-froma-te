<?php

namespace App\Services\Admin;

use App\DTO\Admin\Plan\CreatePlanDTO;
use App\DTO\Admin\Plan\UpdatePlanDTO;
use App\Repositories\Admin\Plan\PlanRepositoryInterface;
use App\Repositories\PaginationInterface;
use Illuminate\Http\Request;

class PlanService
{
    public function __construct(
        protected PlanRepositoryInterface $repository
    ) {
    }

    public function paginate(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function store(CreatePlanDTO $dto)
    {
        return $this->repository->store($dto);
    }

    public function show(string $url)
    {
        return $this->repository->show($url);
    }

    public function edit(string $url)
    {
        return $this->repository->edit($url);
    }

    public function update(UpdatePlanDTO $dto)
    {
        return $this->repository->update($dto);
    }

    public function delete(string $url)
    {
        $this->repository->delete($url);
    }
}
