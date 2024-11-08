<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;

interface AffiliateRepositoryInterface
{
    public function createAffiliate(CreateAffiliateDTO $dto);
    public function findById(string $id): object|null;
    public function getAffiliates(): object|null;
    public function saleAffiliate(SaleAffiliateDTO $dto);
    public function fetchProductDataAffiliate(string $product_url);
    public function delete(string $id): void;
}
