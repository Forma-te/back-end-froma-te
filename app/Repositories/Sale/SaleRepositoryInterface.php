<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\ImportCsvDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Models\Sale;
use App\Repositories\PaginationInterface;

interface SaleRepositoryInterface
{
    public function getMyStudents(int $page = 1, int $totalPerPage = 15, string $status = '', string $filter = null): PaginationInterface;
    //public function getMembersByStatus(int $page = 1, int $totalPerPage  = 10, string $status = '', string $filter = null): PaginationInterface;
    public function findById(string $id): object|null;
    //public function createNewSale(CreateNewSaleDTO $dto);
    public function csvImportMember(ImportCsvDTO $dto);
    public function updateSale(UpdateNewSaleDTO $dto): ?Sale;
    public function delete(string $id): void;
}
