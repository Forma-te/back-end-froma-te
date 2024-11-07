<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;

interface AffiliateRepositoryInterface
{
    public function createAffiliate(CreateAffiliateDTO $dto);
    public function getAffiliates(): object|null;
    public function saleAffiliate(SaleAffiliateDTO $dto);
}
