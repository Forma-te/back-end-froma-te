<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Models\Sale;
use App\Repositories\PaginationInterface;

interface SaleRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getMyStudents(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getMyStudentsStatusExpired(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function createNewSale(CreateNewSaleDTO $dto);
    public function updateSale(UpdateNewSaleDTO $dto): ?Sale;
    public function delete(string $id): void;
}
