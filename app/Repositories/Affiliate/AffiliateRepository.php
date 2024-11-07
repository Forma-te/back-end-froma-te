<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
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
        $existingAffiliateItem = $this->entity::where('user_id', $dto->user_id)
                                    ->where('product_url', $dto->product_url)
                                    ->first();

        if ($existingAffiliateItem) {
            return $existingAffiliateItem;
        }

        return $this->entity->create($dto->toArray());
    }

    public function getAffiliates(): object|null
    {
        return $this->entity
                    ->userByAuth()
                    ->with('user', 'product')
                    ->get();

    }

    public function saleAffiliate(SaleAffiliateDTO $dto)
    {

    }
}
