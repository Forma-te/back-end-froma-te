<?php

namespace App\Http\Controllers\Api\Member;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleAffiliateRequest;
use App\Http\Requests\StoreAffiliateRequest;
use App\Models\Affiliate;
use App\Models\AffiliateLink;
use App\Repositories\Affiliate\AffiliateLinkRepository;
use App\Repositories\Course\CourseRepository;
use App\Services\AffiliateService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AffiliateController extends Controller
{
    public function __construct(
        protected AffiliateService $affiliateService,
        protected AffiliateLinkRepository $affiliateLinkRepository,
        protected CourseRepository $courseRepository
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

    public function myAffiliations()
    {
        $affiliations = $this->affiliateService->myAffiliations();

        return response()->json([
            'data' => $affiliations ?? [],
        ]);
    }

    public function myAffiliates()
    {
        $affiliates = $this->affiliateService->myAffiliates();

        return response()->json([
            'data' => $affiliates ?? [],
        ]);
    }

    public function saleAffiliate(SaleAffiliateRequest $request)
    {
        $saleAffiliate = $this->affiliateService->saleAffiliate(SaleAffiliateDTO::makeFromRequest($request));

        return response()->json($saleAffiliate);
    }

    public function destroyAffiliate(string $id)
    {
        if (!$this->affiliateService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->affiliateService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getAffiliateLink($productUrl, $refCode)
    {
        // Verifica se o código de referência (unique_code) existe em AffiliateLink
        $affiliateLink = AffiliateLink::where('unique_code', $refCode)->first();

        if (!$affiliateLink) {
            return response()->json(['message' => 'Código de referência inválido.'], 404);
        }

        // Verifica se existe uma afiliação associada ao productUrl e ao código de referência, com status 'active'
        $affiliate = Affiliate::where('product_url', $productUrl)
                              ->where('affiliate_link_id', $affiliateLink->id)
                              ->where('status', 'active')
                              ->first();

        if (!$affiliate) {
            return response()->json(['message' => 'Afiliação não encontrada ou inativa para este produto.'], 404);
        }

        // Se as validações passarem, gera o link de afiliação
        $link = route('product.show', ['productUtl' => $productUrl]) . '?ref=' . $refCode;

        return response()->json([
            'affiliate_link' => $link
        ]);
    }
}
