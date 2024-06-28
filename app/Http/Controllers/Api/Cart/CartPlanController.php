<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\cartPlanResource;
use App\Services\CartPlanService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CartPlanController extends Controller
{
    public function __construct(
        protected CartPlanService $cartPlanService
    ) {
    }

    public function getAllPlans()
    {
        try {
            $cartPlans = $this->cartPlanService->getAllPlans();

            if ($cartPlans->isEmpty()) {
                return response()->json([
                    'error' => 'Resource not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return CartPlanResource::collection($cartPlans);
        } catch (\Exception $e) {
            Log::error('Error fetching plans: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while fetching plans'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createSessionPlan(Request $request, string $urlPlan)
    {
        $plan = $this->cartPlanService->createSessionPlan($request, $urlPlan);

        if (empty($plan)) {
            return response()->json([
                'error' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($plan);
    }

    public function checkoutPlan()
    {
        try {
            $plan = $this->cartPlanService->checkoutPlan();

            if (empty($plan)) {
                Log::info('Session plan not found');
                return response()->json([
                    'error' => 'Session plan not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($plan);
        } catch (\Exception $e) {
            Log::error('Error during checkout: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred during checkout'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function planPay()
    {
        try {
            $plan = $this->cartPlanService->planPay();

            return response()->json($plan);
        } catch (\Exception $e) {
            Log::error('Error processing payment: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while processing payment'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
