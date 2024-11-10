<?php

namespace App\Services;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
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

    public function findById(string $id): object|null
    {
        return $this->affiliateRepository->findById($id);
    }

    public function fetchProductDataAffiliate(string $product_url)
    {
        return $this->affiliateRepository->fetchProductDataAffiliate($product_url);
    }

    public function myAffiliations()
    {
        return $this->affiliateRepository->myAffiliations();
    }

    public function myAffiliates(): object|null
    {
        return $this->affiliateRepository->myAffiliates();
    }

    public function saleAffiliate(SaleAffiliateDTO $dto)
    {
        return $this->affiliateRepository->saleAffiliate($dto);
    }

    public function delete(string $id): void
    {
        $this->affiliateRepository->delete($id);
    }
}
