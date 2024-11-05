<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\Models\Affiliate;

class AffiliateRepository implements AffiliateRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Affiliate $entity
    ) {
    }

    public function createAffiliate(CreateAffiliateDTO $dto)
    {
        return $this->entity->create($dto->toArray());
    }
}
