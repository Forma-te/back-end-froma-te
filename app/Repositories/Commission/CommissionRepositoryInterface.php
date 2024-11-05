<?php

namespace App\Repositories\Commission;

use App\DTO\Commission\CreateCommissionDTO;

interface CommissionRepositoryInterface
{
    public function createCommission(CreateCommissionDTO  $dto);
}
