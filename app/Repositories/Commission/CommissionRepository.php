<?php

namespace App\Repositories\Commission;

use App\DTO\Commission\CreateCommissionDTO;
use App\Models\Commission;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function __construct(
        protected Commission $entity
    ) {
    }

    public function createCommission(CreateCommissionDTO $dto)
    {
        return $this->entity->create([
            'affiliate_id' => $dto->affiliate_id,
            'amount' => $dto->amount,
            'status' => $dto->status,
        ]);
    }
}
