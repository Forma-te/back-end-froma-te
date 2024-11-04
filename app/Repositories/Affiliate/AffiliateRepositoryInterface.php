<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;

interface AffiliateRepositoryInterface
{
    public function createAffiliate(CreateAffiliateDTO $dto);
}
