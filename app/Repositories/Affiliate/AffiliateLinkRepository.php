<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\Models\Affiliate;
use App\Models\AffiliateLink;
use Illuminate\Support\Str;

class AffiliateLinkRepository implements AffiliateLinkRepositoryInterface
{
    public function findByProductAndAffiliate($productId, $affiliateId)
    {
        return AffiliateLink::where('product_id', $productId)
                            ->where('affiliate_id', $affiliateId)
                            ->first();
    }

    public function createAffiliateLink(CreateAffiliateDTO $dto, $userId)
    {
        // Verifica se o ID do afiliado é igual ao affiliate_id
        $existingAffiliateLink = AffiliateLink::where('user_id', $dto->user_id) ->first();

        if ($existingAffiliateLink) {
            return $existingAffiliateLink;
        }

        // Cria o link único de afiliação
        return AffiliateLink::create([
            'user_id' => $dto->user_id,
            'unique_code' => Str::uuid()->toString() // Gera um UUID único para o link
        ]);
    }

    public function findByUserId($userId)
    {
        return AffiliateLink::where('user_id', $userId)->first();
    }

    public function findByReference(string $affiliateRef)
    {
        return AffiliateLink::where('unique_code', $affiliateRef)->first();
    }

    public function generateAffiliateLink(string $productUrl, Affiliate $affiliate): string
    {
        // Verificar se o affiliateLink foi carregado corretamente
        if (!$affiliate->affiliateLink) {
            // Tratar o caso onde o affiliateLink não existe
            throw new \Exception('Affiliate link not found for the given affiliate.');
        }

        return route('product.show', ['productUtl' => $productUrl]) . '?ref=' . $affiliate->affiliateLink->unique_code;
    }

}
