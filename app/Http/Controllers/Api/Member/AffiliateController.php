<?php

namespace App\Http\Controllers\Api\Member;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleAffiliateRequest;
use App\Http\Requests\StoreAffiliateRequest;
use App\Models\Affiliate;
use App\Models\Product;
use App\Repositories\Affiliate\AffiliateLinkRepository;
use App\Services\AffiliateService;
use Exception;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function __construct(
        protected AffiliateService $affiliateService,
        protected AffiliateLinkRepository $affiliateLinkRepository
    ) {
    }

    public function store(StoreAffiliateRequest $request)
    {
        try {
            // Cria o DTO com os dados da requisição
            $affiliateDto = CreateAffiliateDTO::makeFromRequest($request);

            // Cria a afiliação e o link de afiliação
            $affiliateData = $this->affiliateService->createAffiliate($affiliateDto);

            return response()->json([
                'message' => 'Afiliação e link de afiliação criados com sucesso.',
                'affiliate' => $affiliateData['affiliate'],
                'affiliate_link' => $affiliateData['affiliate_link'],
            ], 201);
        } catch (Exception $e) {
            // Captura exceções e retorna uma resposta de erro
            return response()->json([
                'error' => 'Erro ao criar a afiliação.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateLink($productId, $affiliateId)
    {
        // Busca o afiliado pelo ID
        $affiliate = Affiliate::findOrFail($affiliateId);

        // Gera o link de afiliação
        $link = $this->affiliateLinkRepository->generateAffiliateLink($productId, $affiliate);

        // Retorna o link para ver o resultado
        return response()->json([
            'affiliate_link' => $link,
        ]);
    }

    public function fetchProductDataAffiliate(string $product_url)
    {
        $product = $this->affiliateService->fetchProductDataAffiliate($product_url);

        return response()->json([
            'data' => $product ?? [],
        ]);
    }


    public function getAffiliates()
    {
        $affiliates = $this->affiliateService->getAffiliates();

        return response()->json([
            'data' => $affiliates ?? [],
        ]);
    }

    public function saleAffiliate(SaleAffiliateRequest $request)
    {
        $SaleAffiliate = $this->affiliateService->saleAffiliate(SaleAffiliateDTO::makeFromRequest($request));

        return response()->json($SaleAffiliate);
    }
}
