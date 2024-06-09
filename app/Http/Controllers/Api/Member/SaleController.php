<?php

namespace App\Http\Controllers\Api\Member;

use App\Adapters\ApiAdapter;
use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService $saleService
    ) {
    }

    public function getAllSales(Request $request)
    {
        $sale = $this->saleService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($sale);
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    public function getSaleById(string $id)
    {
        $sale = $this->saleService->findById($id);
        if (Gate::denies('owner-sale', $sale)) {
            return response()->json([
                'error' => 'Forbidden'
            ], Response::HTTP_FORBIDDEN);
        }

        if (!$sale) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

        return new SaleResource($sale);
    }

    public function newSale(StoreUpdateSaleRequest $request)
    {
        $bank = $this->saleService->createNewSale(
            CreateNewSaleDTO::makeFromRequest($request)
        );

        return new SaleResource($bank);
    }

    public function updateSale(StoreUpdateSaleRequest $request, string $id)
    {
        $sale = $this->saleService->updateSale(
            UpdateNewSaleDTO::makeFromRequest($request, $id)
        );

        if(!$sale) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        return new SaleResource($sale);
    }

    public function destroySele(string $id)
    {
        if(!$this->saleService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        $this->saleService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
