<?php

namespace App\Services;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Models\Sale;
use App\Repositories\PaginationInterface;
use App\Repositories\Sale\SaleRepositoryInterface;

class SaleService
{
    public function __construct(
        protected SaleRepositoryInterface $repository
    ) {
    }

    public function getMyStudents(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->getMyStudents(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function getMembersByStatus(
        int $page = 1,
        int $totalPerPage  = 15,
        string $status = null,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->getMembersByStatus(
            page: $page,
            totalPerPage: $totalPerPage,
            status: $status,
            filter: $filter
        );
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function createNewSale(CreateNewSaleDTO $dto)
    {
        return $this->repository->createNewSale($dto);
    }

    public function updateSale(UpdateNewSaleDTO $dto): Sale
    {
        return $this->repository->updateSale($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

}
