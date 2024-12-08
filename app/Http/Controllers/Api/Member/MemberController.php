<?php

namespace App\Http\Controllers\Api\Member;

use App\Adapters\AffiliateAdapters;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\Member\MemberRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function __construct(
        protected MemberRepository $repository
    ) {
    }

    public function getAllProductsMember(Request $request)
    {
        try {

            $defaultPerPage = 10;
            $maxPerPage = 100;

            // Obter o valor do parâmetro per_page da requisição
            $totalPerPage = (int) $request->get('per_page', $defaultPerPage);

            // Validar o valor recebido
            if ($totalPerPage <= 0 || $totalPerPage > $maxPerPage) {
                $totalPerPage = $defaultPerPage;
            }

            // Obter todos os cursos associados ao membro atual
            $products = $this->repository->getAllProductsMember(
                page: $request->get('page', 1),
                totalPerPage: $totalPerPage,
                filter: $request->get('filter', '')
            );

            return response()->json([
                AffiliateAdapters::paginateToJson($products),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Tratar erros e retornar uma resposta adequada
            return response()->json([
                'message' => 'Failed to retrieve products: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProductByIdMember($id)
    {
        // Tenta encontrar o curso pelo ID usando o repositório
        $product = $this->repository->getProductByIdMember($id);

        // Verifica se o curso foi encontrado
        if (!$product) {
            return response()->json([
                'data' => []
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $product
        ], Response::HTTP_OK);
    }

}
