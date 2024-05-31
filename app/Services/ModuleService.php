<?php

namespace App\Services;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Models\Module;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\PaginationInterface;
use stdClass;

class ModuleService
{
    public function __construct(
        protected ModuleRepositoryInterface $repository
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

    public function getModulesByCourseId(string $courseId): ?array
    {
        return $this->repository->getModulesByCourseId($courseId);
    }

    public function new(CreateModuleDTO $dto): Module
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateModuleDTO $dto): Module|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

}
