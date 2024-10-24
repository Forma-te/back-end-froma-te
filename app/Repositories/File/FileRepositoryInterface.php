<?php

namespace App\Repositories\File;

use App\DTO\File\CreateFileDTO;
use App\DTO\File\UpdateFileDTO;
use App\Models\Product;
use App\Repositories\PaginationInterface;

interface FileRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface;
    public function fetchAllFilesByProducers(int $page = 1, int $totalPerPage  = 15, string $filter = null, $producerName = null, string $categoryName = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function new(CreateFileDTO $dto): Product;
    public function update(UpdateFileDTO $dto): ?Product;
    public function delete(string $id): void;
    public function getFileById(string $id): object|null;
    public function getFileByUrl(string $url): ?Product;
}
