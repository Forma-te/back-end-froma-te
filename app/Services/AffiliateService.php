<?php

namespace App\Services;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
use App\Repositories\Affiliate\AffiliateLinkRepository;
use App\Repositories\Affiliate\AffiliateRepository;
use App\Repositories\PaginationInterface;

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


    public function myAffiliations(
        int $page = 1,
        int $totalPerPage  = 10,
        string $filter = null
    ): PaginationInterface {
        return $this->affiliateRepository->myAffiliations(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function myAffiliates(
        int $page = 1,
        int $totalPerPage  = 10,
        string $filter = null
    ): PaginationInterface {
        return $this->affiliateRepository->myAffiliates(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter
        );
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
