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

    /**
     * @OA\Get(
     *     path="/api/plans",
     *     operationId="getAllPlans",
     *     tags={"Producer Plan"},
     *     summary="Get all published plans",
     *     description="Returns a list of all published plans",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CartPlanResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Resource not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred while fetching plans",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="An error occurred while fetching plans")
     *         )
     *     )
     * )
     */

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

    /**
    * @OA\Get(
    *     path="/api/cart/plans/{urlPlan}",
    *     operationId="createSessionPlan",
    *     tags={"Producer Plan"},
    *     summary="Create a session plan",
    *     description="Creates a session plan based on the given URL plan and returns the plan details",
    *     @OA\Parameter(
    *         name="urlPlan",
    *         in="path",
    *         description="URL of the plan",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="basic-plan"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="cartPlan", type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="name", type="string", example="Básico Mensal"),
    *                 @OA\Property(property="url", type="string", example="basico-mensal"),
    *                 @OA\Property(property="description", type="string", example="Básico Mensal"),
    *                 @OA\Property(property="price", type="number", example=15000),
    *                 @OA\Property(property="quantity", type="integer", example=1),
    *                 @OA\Property(property="published", type="integer", example=1),
    *                 @OA\Property(property="created_at", type="string", format="date-time", example="2022-12-23T23:42:36.000000Z"),
    *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2022-12-23T23:46:10.000000Z")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Resource not found",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="error", type="string", example="Resource not found")
    *         )
    *     )
    * )
    */
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

    /**
      * @OA\Get(
      *     path="/api/cart/checkout",
      *     operationId="checkoutPlan",
      *     tags={"Producer Plan"},
      *     summary="Checkout the current session plan",
      *     description="Returns the current session plan if it exists, or an error message if the plan is not found or an error occurs",
      *     @OA\Response(
      *         response=200,
      *         description="Successful operation",
      *         @OA\JsonContent(
      *             type="object",
      *             @OA\Property(property="cartPlan", type="object",
      *                 @OA\Property(property="id", type="integer", example=1),
      *                 @OA\Property(property="name", type="string", example="Básico Mensal"),
      *                 @OA\Property(property="url", type="string", example="basico-mensal"),
      *                 @OA\Property(property="description", type="string", example="Básico Mensal"),
      *                 @OA\Property(property="price", type="number", example=15000),
      *                 @OA\Property(property="quantity", type="integer", example=1),
      *                 @OA\Property(property="published", type="integer", example=1),
      *                 @OA\Property(property="created_at", type="string", format="date-time", example="2022-12-23T23:42:36.000000Z"),
      *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2022-12-23T23:46:10.000000Z")
      *             )
      *         )
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Session plan not found",
      *         @OA\JsonContent(
      *             type="object",
      *             @OA\Property(property="error", type="string", example="Session plan not found")
      *         )
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="An error occurred during checkout",
      *         @OA\JsonContent(
      *             type="object",
      *             @OA\Property(property="error", type="string", example="An error occurred during checkout")
      *         )
      *     )
      * )
      */
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

    /**
     * @OA\Post(
     *     path="/api/cart/plan-pay",
     *     operationId="planPay",
     *     tags={"Producer Plan"},
     *     summary="Process plan payment",
     *     description="Processes the payment for the current session plan and returns the result",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="producer_id", type="integer", example=1),
     *             @OA\Property(property="plan_id", type="integer", example=1),
     *             @OA\Property(property="email", type="string", example="moises-alberto@hotmail.com"),
     *             @OA\Property(property="quantity", type="integer", example=1),
     *             @OA\Property(property="price", type="number", format="float", example=15000),
     *             @OA\Property(property="total", type="number", format="float", example=15000),
     *             @OA\Property(property="transaction", type="string", example="0346E5EF"),
     *             @OA\Property(property="status", type="string", example="started"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-06-28"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-28T20:04:31.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-28T20:04:31.000000Z"),
     *             @OA\Property(property="id", type="integer", example=21)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="No plan in cart",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="No plan in cart")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producer not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Producer not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred while processing payment",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="An error occurred while processing payment")
     *         )
     *     )
     * )
     */
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
