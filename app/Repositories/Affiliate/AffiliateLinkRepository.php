<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\Models\Affiliate;
use App\Models\AffiliateLink;
use Illuminate\Support\Str;

class AffiliateLinkRepository implements AffiliateLinkRepositoryInterface
{
    public function createAffiliateLink(CreateAffiliateDTO $dto, Affiliate $affiliate): AffiliateLink
    {
        // Verifica se o ID do afiliado é igual ao affiliate_id
        $existingAffiliateLink = AffiliateLink::where('user_id', $dto->user_id) ->first();

        if ($existingAffiliateLink) {
            return $existingAffiliateLink;
        }


        // Cria o link único de afiliação
        return AffiliateLink::create([
            'affiliate_id' => $affiliate->id,
            'user_id' => $dto->user_id,
            'unique_code' => Str::uuid()->toString() // Gera um UUID único para o link
        ]);
    }

    public function findByProductAndAffiliate($productId, $affiliateId)
    {
        return AffiliateLink::where('product_id', $productId)
                            ->where('affiliate_id', $affiliateId)
                            ->first();
    }

    public function generateAffiliateLink(string $productUrl, Affiliate $affiliate): string
    {
        return route('product.show', ['productUtl' => $productUrl]) . '?ref=' . $affiliate->affiliateLink->unique_code;
    }

}
