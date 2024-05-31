<?php

namespace App\Repositories\Module;

use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Models\Module;
use App\Repositories\PaginationInterface;
use stdClass;

interface ModuleRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getModulesByCourseId(string $courseId): ?array;
    public function new(CreateModuleDTO $dto): Module;
    public function update(UpdateModuleDTO $dto): Module|null;
    public function delete(string $id): void;

}
