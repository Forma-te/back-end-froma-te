<?php

namespace App\Http\Controllers\Api;

use App\DTO\Bank\CreateBankDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateBankRequest;
use App\Http\Resources\BankResource;
use App\Services\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __construct(
        protected BankService $bankService
    ) {
    }

    public function createBank(StoreUpdateBankRequest $request)
    {
        $bank = $this->bankService->create(
            CreateBankDTO::makeFromRequest($request)
        );

        return new BankResource($bank);
    }

}
