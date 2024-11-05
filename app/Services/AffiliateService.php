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

        $affiliateLink = $this->affiliateLinkRepository->createAffiliateLink($affiliate);

        // Gera o link de afiliação para o produto associado
        $productId = $dto->product_id; // Supondo que o DTO tem o ID do produto
        $link = $this->affiliateLinkRepository->generateAffiliateLink($productId, $affiliate->id);

        return [
            'affiliate' => $affiliate,
            'affiliate_link' => $affiliateLink,
            'generated_link' => $link
        ];
    }
}
