<?php

namespace App\Repositories\Ebook;

use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Models\Ebook;
use App\Repositories\PaginationInterface;

interface EbookRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function new(CreateEbookDTO $dto): Ebook;
    public function update(UpdateEbookDTO $dto): ?Ebook;
    public function delete(string $id): void;
}
