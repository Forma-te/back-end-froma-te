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
        $cartPlans = $this->cartPlanService->getAllPlans();

        if (empty($cartPlans)) {
            return response()->json([
                'error' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return CartPlanResource::collection($cartPlans);
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
        $plan = $this->cartPlanService->checkoutPlan();

        if (empty($plan)) {
            Log::info('Session plan not found');
            return response()->json([
                'error' => 'Session plan not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($plan);
    }
}
