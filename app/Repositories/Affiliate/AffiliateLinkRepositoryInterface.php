<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\Models\Affiliate;
use App\Models\AffiliateLink;

interface AffiliateLinkRepositoryInterface
{
    public function createAffiliateLink(CreateAffiliateDTO $dto, $userId);
}
