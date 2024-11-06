<?php

namespace App\Services;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\Repositories\Affiliate\AffiliateLinkRepository;
use App\Repositories\Affiliate\AffiliateRepository;

class AffiliateService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AffiliateRepository $affiliateRepository,
        //protected CommissionRepository $commissionRepository,
        protected AffiliateLinkRepository $affiliateLinkRepository
    ) {
    }

    public function createAffiliate(CreateAffiliateDTO $dto)
    {

        $affiliate = $this->affiliateRepository->createAffiliate($dto);

        $affiliateLink = $this->affiliateLinkRepository->createAffiliateLink($dto, $affiliate);

        return [
            'affiliate' => $affiliate,
            'affiliate_link' => $affiliateLink
        ];
    }

    public function getAffiliates()
    {
        return $this->affiliateRepository->getAffiliates();
    }
}
