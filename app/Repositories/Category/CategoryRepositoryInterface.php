<?php

namespace App\Repositories\Category;

use App\DTO\Category\CreateCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\Repositories\PaginationInterface;
use stdClass;

interface CategoryRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function new(CreateCategoryDTO $dto): stdClass;
    public function update(UpdateCategoryDTO $dto): stdClass|null;
    public function delete(string $id): void;
}
