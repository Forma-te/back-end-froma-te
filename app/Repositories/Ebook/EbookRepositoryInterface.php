<?php

namespace App\Repositories\Ebook;

use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Models\Product;
use App\Repositories\PaginationInterface;

interface EbookRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface;
    public function fetchAllEbooksByProducers(int $page = 1, int $totalPerPage  = 15, string $filter = null, $producerName = null, string $categoryName = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function new(CreateEbookDTO $dto): Product;
    public function update(UpdateEbookDTO $dto): ?Product;
    public function delete(string $id): void;
    public function getEbookById(string $id): object|null;
    public function getEbookByUrl(string $url): ?Product;
}
