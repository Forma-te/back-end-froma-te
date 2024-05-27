<?php

namespace App\Services;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
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

    public function create(CreateModuleDTO $dto): stdClass
    {
        return $this->repository->create($dto);
    }

    public function update(UpdateModuleDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(string $id): stdClass|null
    {
        return $this->repository->findById($id);
    }
}
