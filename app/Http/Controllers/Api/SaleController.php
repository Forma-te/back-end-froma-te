<?php

namespace App\Http\Controllers\Api;

use App\DTO\Sale\CreateNewSaleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService $saleService
    ) {
    }

    public function newSale(StoreUpdateSaleRequest $request)
    {
        $bank = $this->saleService->createNewSale(
            CreateNewSaleDTO::makeFromRequest($request)
        );

        return new SaleResource($bank);

    }
}
