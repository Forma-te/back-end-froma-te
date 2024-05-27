<?php

namespace App\Repositories\Module;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Repositories\PaginationInterface;
use stdClass;

interface ModuleRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function create(CreateModuleDTO $dto): stdClass;
    public function update(UpdateModuleDTO $dto): stdClass|null;
    public function delete(string $id): void;
    public function findById(string $id): stdClass|null;
}
