<?php

namespace App\Repositories\Affiliate;

use App\Models\Affiliate;
use App\Models\AffiliateLink;
use Illuminate\Support\Str;

class AffiliateLinkRepository implements AffiliateLinkRepositoryInterface
{
    public function createAffiliateLink(Affiliate $affiliate): AffiliateLink
    {
        // Cria o link único de afiliação
        return AffiliateLink::create([
            'affiliate_id' => $affiliate->id,
            'unique_code' => Str::uuid()->toString() // Gera um UUID único para o link
        ]);
    }

    public function findByProductAndAffiliate($productId, $affiliateId)
    {
        return AffiliateLink::where('product_id', $productId)
                            ->where('affiliate_id', $affiliateId)
                            ->first();
    }

    public function generateAffiliateLink(int $productId, Affiliate $affiliate): string
    {
        return route('product.show', ['productId' => $productId]) . '?ref=' . $affiliate->affiliateLink->unique_code;
    }

}
