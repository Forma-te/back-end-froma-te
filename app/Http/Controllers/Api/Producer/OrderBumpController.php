<?php

namespace App\Http\Controllers\Api\Producer;

use App\DTO\OrderBump\CreateOrderBumpDTO;
use App\DTO\OrderBump\UpdateOrderBumpDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOrderBumpRequest;
use App\Http\Resources\OrderBumpResource;
use App\Services\OrderBumpService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderBumpController extends Controller
{
    public function __construct(
        protected OrderBumpService $OrderBumpService
    ) {
    }

    public function getOrderBump()
    {
        $orderBump = $this->OrderBumpService->getAll();

        return OrderBumpResource::collection($orderBump);
    }

    public function createOrderBump(StoreUpdateOrderBumpRequest $request)
    {
        try {
            $orderBump = $this->OrderBumpService->create(
                CreateOrderBumpDTO::makeFromRequest($request)
            );

            return new OrderBumpResource($orderBump);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422); // Unprocessable Entity
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar Order Bump: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function updateOrderBump(StoreUpdateOrderBumpRequest $request, string $id)
    {
        $orderBump = $this->OrderBumpService->update(
            UpdateOrderBumpDTO::makeFromRequest($request, $id)
        );

        if (!$orderBump) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new OrderBumpResource($orderBump);
    }

    public function deleteOrderBump(string $id)
    {
        if (!$this->OrderBumpService->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->OrderBumpService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
