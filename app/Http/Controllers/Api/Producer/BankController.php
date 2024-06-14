<?php

namespace App\Http\Controllers\Api\Producer;

use App\DTO\Bank\CreateBankDTO;
use App\DTO\Bank\UpdateBankDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateBankRequest;
use App\Http\Resources\BankResource;
use App\Services\BankService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BankController extends Controller
{
    public function __construct(
        protected BankService $bankService
    ) {
    }

    public function createBank(StoreUpdateBankRequest $request)
    {
        try {
            $bank = $this->bankService->create(
                CreateBankDTO::makeFromRequest($request)
            );

            return new BankResource($bank);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar banco: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function findBankByUserId(string $userId)
    {
        $bankByUserId = $this->bankService->findBankByUserId($userId);
    }

    public function updateBank(StoreUpdateBankRequest $request, string $id)
    {
        $bank = $this->bankService->update(
            UpdateBankDTO::makeFromRequest($request, $id)
        );

        if (!$bank) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new BankResource($bank);
    }

    public function deleteBank(string $id)
    {
        if (!$this->bankService->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->bankService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);

    }

}
