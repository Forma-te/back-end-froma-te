<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Models\Sale;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        protected Sale $model
    ) {
    }

    public function createNewSale(CreateNewSaleDTO $dto)
    {
    }

    public function updateNewSale(UpdateNewSaleDTO $dto)
    {
    }
}
