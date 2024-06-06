<?php

namespace App\Services;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Repositories\Sale\SaleRepositoryInterface;

class SaleService
{
    public function __construct(
        protected SaleRepositoryInterface $repository
    ) {
    }

    public function createNewSale(CreateNewSaleDTO $dto)
    {
        return $this->repository->createNewSale($dto);
    }

    public function updateNewSale(UpdateNewSaleDTO $dto)
    {
        return $this->repository->updateNewSale($dto);
    }
}
