<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;

interface SaleRepositoryInterface
{
    public function createNewSale(CreateNewSaleDTO $dto);
    public function updateNewSale(UpdateNewSaleDTO $dto);
}
