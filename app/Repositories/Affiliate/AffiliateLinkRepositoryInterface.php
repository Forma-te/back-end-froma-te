<?php

namespace App\Repositories\Affiliate;

use App\Models\Affiliate;
use App\Models\AffiliateLink;

interface AffiliateLinkRepositoryInterface
{
    public function createAffiliateLink(Affiliate $affiliate): AffiliateLink;
}
