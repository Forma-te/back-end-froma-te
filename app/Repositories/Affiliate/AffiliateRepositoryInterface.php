<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
use App\Repositories\PaginationInterface;

interface AffiliateRepositoryInterface
{
    public function createAffiliate(CreateAffiliateDTO $dto);
    public function myAffiliations(
        int $page = 1,
        int $totalPerPage = 10,
        string $filter = null,
    ): PaginationInterface;

    public function myAffiliates(
        int $page = 1,
        int $totalPerPage = 10,
        string $filter = null,
    ): PaginationInterface;

    public function saleAffiliate(SaleAffiliateDTO $dto);
    //public function fetchProductDataAffiliate(string $product_url);
    public function delete(string $id): void;
}
