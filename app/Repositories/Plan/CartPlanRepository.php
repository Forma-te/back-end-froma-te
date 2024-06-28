<?php

namespace App\Repositories\Plan;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartPlanRepository implements CartPlanRepositoryInterface
{
    public function __construct(
        protected Plan $entity
    ) {
    }

    public function getAllPlans()
    {
        return $this->entity->where('published', '1')->get();
    }

    public function createSessionPlan(Request $request, string $urlPlan)
    {
        $cartPlan = $this->entity->where('url', $urlPlan)->first();
        if (!$cartPlan) {
            return response()->json([], 404);
        }

        $request->session()->put('cartPlan', $cartPlan);

        return response()->json($cartPlan);
    }

    public function checkoutPlan()
    {
        $cartPlan =  ['cartPlan' => session('cartPlan')];
        return response()->json($cartPlan);
    }


}
